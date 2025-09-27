import os
import mysql.connector
import logging
from datetime import datetime
from dotenv import load_dotenv
from openai import OpenAI
import re
from typing import Dict, Any, List, Optional
import time
from tenacity import retry, stop_after_attempt, wait_exponential
import uuid
import json
from contextlib import contextmanager

# Charger les variables d'environnement
load_dotenv()

# Configuration du logging
def setup_logging():
    """Configure le logging pour écrire dans un fichier et afficher dans la console"""
    log_format = '%(asctime)s - %(levelname)s - %(message)s'
    date_format = '%Y-%m-%d %H:%M:%S'
    log_filename = f'migration_modules_{datetime.now().strftime("%Y%m%d_%H%M%S")}.log'

    logger = logging.getLogger()
    logger.setLevel(logging.INFO)

    # Handler pour fichier
    file_handler = logging.FileHandler(log_filename)
    file_handler.setFormatter(logging.Formatter(log_format, date_format))
    logger.addHandler(file_handler)

    # Handler pour console
    console_handler = logging.StreamHandler()
    console_handler.setFormatter(logging.Formatter(log_format, date_format))
    logger.addHandler(console_handler)

    return logger

logger = setup_logging()

class DeepSeekClient:
    """Client pour l'API DeepSeek pour la correction orthographique et grammaticale"""

    def __init__(self):
        self.client = OpenAI(
            api_key=os.getenv("DEEPSEEK_API_KEY"),
            base_url=os.getenv("DEEPSEEK_API_URL", "https://api.deepseek.com")
        )

    @retry(
        stop=stop_after_attempt(3),
        wait=wait_exponential(multiplier=2, min=4, max=30)
    )
    def extract_and_correct_modules(self, content: str) -> List[Dict[str, str]]:
        """Extrait et corrige les modules via l'IA avec validation du format"""
        try:
            response = self.client.chat.completions.create(
                model="gpt-4o-mini",
                messages=[
                    {
                        "role": "system",
                        "content": (
                            "Tu es un expert en analyse et structuration de contenus pédagogiques. "
                            "Ta mission est d'identifier et de séparer les différents modules d'une formation. "
                            "\nRègles importantes pour le formatage du contenu:"
                            "\n1. Chaque point ou section doit être séparé par une ligne vide"
                            "\n2. Transformer les listes à puces (·, -, *, •) en paragraphes distincts"
                            "\n3. Assurer qu'il y a toujours une ligne vide entre chaque section"
                            "\n4. Conserver la hiérarchie et l'ordre logique du contenu"
                            "\nExemple de formatage attendu:"
                            "\nSection 1"
                            "\n"
                            "\nSection 2"
                            "\n"
                            "\nSection 3"
                            "\n"
                            "\nIMPORTANT: Tu dois TOUJOURS retourner un JSON valide avec la structure exacte suivante:"
                            '\n{"modules": [{"title": "string", "content": "string"}]}'
                        )
                    },
                    {
                        "role": "user",
                        "content": (
                            "Analyse ce contenu de formation et sépare-le en modules distincts en suivant ces règles :\n\n"
                            "1. IDENTIFICATION DES MODULES :\n"
                            "- Repère les titres commençant par 'Module' (ex: 'Module 1:', 'Module 2 :')\n"
                            "- Identifie les sections numérotées (1., 1.1, etc.)\n"
                            "- Repère les titres en majuscules suivis de ':'\n"
                            "- Identifie les sections avec puces (·, •, -, etc.)\n\n"

                            "2. STRUCTURE DU CONTENU :\n"
                            "- Conserve la hiérarchie existante\n"
                            "- Garde les puces et sous-puces (·, ü, o, etc.)\n"
                            "- Préserve les sauts de ligne significatifs\n"
                            "- Maintiens les indentations d'origine\n\n"

                            "3. CORRECTION DU TEXTE :\n"
                            "- Corrige l'orthographe et la grammaire\n"
                            "- Conserve les termes techniques et spécifiques\n"
                            "- Maintiens les accents et caractères spéciaux\n"
                            "- Garde la ponctuation d'origine\n\n"

                            f"Contenu à analyser :\n{content}\n\n"

                            "Retourne le résultat au format JSON suivant :\n"
                            '{"modules": [{"title": "Titre du module", "content": "Contenu corrigé"}]}\n\n'

                            "EXEMPLES DE SÉPARATION :\n"
                            "1. Si tu vois :\n"
                            "Module 1 : Introduction\n"
                            "· Point 1\n"
                            "· Point 2\n"
                            "Module 2 : Développement\n"
                            "→ Crée 2 modules distincts\n\n"

                            "2. Si tu vois :\n"
                            "INTRODUCTION À LA FORMATION :\n"
                            "Contenu...\n"
                            "PARTIE TECHNIQUE :\n"
                            "→ Crée 2 modules distincts\n\n"

                            "3. Si tu vois :\n"
                            "1. Premier chapitre\n"
                            "1.1 Sous-section\n"
                            "2. Deuxième chapitre\n"
                            "→ Crée des modules par chapitre principal"
                        )
                    }
                ],
                temperature=0.3,
                response_format={"type": "json_object"}
            )

            result = json.loads(response.choices[0].message.content)
            return result['modules']
        except Exception as e:
            logger.error(f"Erreur lors de l'extraction des modules: {str(e)}")
            raise

class ModuleExtractor:
    """Classe pour extraire les modules du contenu"""

    def __init__(self):
        # Patterns pour identifier les titres de modules
        self.title_patterns = [
            r'^[A-Z][^a-z\n]*$',  # Lignes en majuscules
            r'^(?:Module|Chapitre|Partie|Section)\s*\d+\s*[:.-]\s*(.*)',  # Titres numérotés
            r'^\d+\s*[:.)-]\s*(.*)',  # Numéros suivis de texte
            r'^Introduction\b',  # Introduction
            r'^Conclusion\b',  # Conclusion
            r'^\s*•\s*([A-Z].*)',  # Puces avec majuscule
            r'^[IVX]+\s*[:.)-]\s*(.*)'  # Chiffres romains
        ]

    def extract_modules(self, content: str) -> List[Dict[str, str]]:
        """Extrait les modules du contenu"""
        modules = []
        current_title = None
        current_content = []

        lines = content.split('\n')

        for line in lines:
            is_title = False
            for pattern in self.title_patterns:
                if re.match(pattern, line.strip()):
                    # Si on avait déjà un titre, on sauvegarde le module précédent
                    if current_title:
                        modules.append({
                            'title': current_title,
                            'content': '\n'.join(current_content).strip()
                        })
                    current_title = line.strip()
                    current_content = []
                    is_title = True
                    break

            if not is_title and current_title:
                current_content.append(line)

        # Ajouter le dernier module
        if current_title:
            modules.append({
                'title': current_title,
                'content': '\n'.join(current_content).strip()
            })

        return modules

@contextmanager
def get_db_connection():
    """Gestionnaire de contexte pour la connexion à la base de données"""
    db = None
    try:
        db = mysql.connector.connect(
            host=os.getenv("NEW_DB_HOST"),
            port=int(os.getenv("NEW_DB_PORT")),
            user=os.getenv("NEW_DB_USER"),
            password=os.getenv("NEW_DB_PASSWORD"),
            database=os.getenv("NEW_DB_NAME")
        )
        logger.info("✅ Connexion à la base de données établie")
        yield db
    except Exception as e:
        logger.error(f"❌ Erreur de connexion à la base de données: {str(e)}")
        raise
    finally:
        if db and db.is_connected():
            db.close()
            logger.info("📡 Connexion à la base de données fermée")

class CourseModuleMigrator:
    """Classe principale pour la migration des modules"""

    def __init__(self):
        self.deepseek = DeepSeekClient()

    def migrate_modules(self):
        """Effectue la migration des modules"""
        try:
            with get_db_connection() as db:
                with db.cursor(dictionary=True) as cursor:
                    # Récupérer tous les modules existants
                    cursor.execute("SELECT * FROM course_modules")
                    courses = cursor.fetchall()

                    for course in courses:
                        logger.info(f"Traitement du cours ID {course['id']}")

                        # Extraire et corriger les modules via l'IA
                        try:
                            modules = self.deepseek.extract_and_correct_modules(course['content'])

                            if not modules:
                                logger.warning(f"Aucun module trouvé pour le cours {course['id']}")
                                continue

                            # Créer les nouveaux modules
                            for order, module in enumerate(modules):
                                cursor.execute("""
                                    INSERT INTO course_modules
                                    (course_id, title, content, `order`, created_at, updated_at)
                                    VALUES (%s, %s, %s, %s, NOW(), NOW())
                                """, (
                                    course['course_id'],
                                    module['title'],
                                    module['content'],
                                    order
                                ))

                            # Marquer l'ancien module comme traité
                            cursor.execute("""
                                UPDATE course_modules
                                SET content = NULL,
                                    updated_at = NOW()
                                WHERE id = %s
                            """, (course['id'],))

                            db.commit()
                            logger.info(f"✅ Migration réussie pour le cours {course['id']}")

                        except Exception as e:
                            logger.error(f"❌ Erreur lors du traitement du cours {course['id']}: {str(e)}")
                            db.rollback()
                            continue

        except Exception as e:
            logger.error(f"🔥 Erreur lors de la migration: {str(e)}")
            raise

def main():
    """Point d'entrée principal du script"""
    try:
        logger.info("🚀 Début de la migration des modules")
        migrator = CourseModuleMigrator()
        migrator.migrate_modules()
        logger.info("✅ Migration terminée avec succès")
    except Exception as e:
        logger.error(f"❌ Erreur critique: {str(e)}")
        raise

if __name__ == "__main__":
    main()

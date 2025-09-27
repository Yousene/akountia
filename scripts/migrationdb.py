import os
import mysql.connector
from html import unescape
import logging
import re
from bs4 import BeautifulSoup
from unidecode import unidecode
from datetime import datetime
from dotenv import load_dotenv
import requests
import json
import warnings
import time
from tenacity import retry, stop_after_attempt, wait_exponential
import sys
from openai import OpenAI
from typing import Dict, Any, Optional, List
import uuid
import traceback
from contextlib import contextmanager

# Charger les variables d'environnement depuis le fichier .env
load_dotenv()

# Récupérer les informations de connexion à l'ancienne base de données depuis les variables d'environnement
# OLD_DB_HOST = os.getenv("OLD_DB_HOST", "127.0.0.1")
# OLD_DB_PORT = int(os.getenv("OLD_DB_PORT", 3306))
# OLD_DB_USER = os.getenv("OLD_DB_USERNAME", "root")
# OLD_DB_PASSWORD = os.getenv("OLD_DB_PASSWORD", "")
# OLD_DB_NAME = os.getenv("OLD_DB_DATABASE", "migrate_afriqueacademy_ino")

# Récupérer les informations de connexion à la nouvelle base de données depuis les variables d'environnement
NEW_DB_HOST = os.getenv("NEW_DB_HOST")
NEW_DB_PORT = int(os.getenv("NEW_DB_PORT"))
NEW_DB_USER = os.getenv("NEW_DB_USER")
NEW_DB_PASSWORD = os.getenv("NEW_DB_PASSWORD")
NEW_DB_NAME = os.getenv("NEW_DB_NAME")

# Connexion à l'ancienne base de données
# old_db = mysql.connector.connect(
#     host=OLD_DB_HOST,
#     port=OLD_DB_PORT,
#     user=OLD_DB_USER,
#     password=OLD_DB_PASSWORD,
#     database=OLD_DB_NAME
# )

# Connexion à la nouvelle base de données
new_db = mysql.connector.connect(
    host=NEW_DB_HOST,
    port=NEW_DB_PORT,
    user=NEW_DB_USER,
    password=NEW_DB_PASSWORD,
    database=NEW_DB_NAME
)

# Configuration du logging pour fichier et console
def setup_logging():
    """Configure le logging pour écrire dans un fichier et afficher dans la console"""
    # Création du format de log
    log_format = '%(asctime)s - %(levelname)s - %(message)s'
    date_format = '%Y-%m-%d %H:%M:%S'

    # Nom du fichier de log avec timestamp
    log_filename = f'migration_{datetime.now().strftime("%Y%m%d_%H%M%S")}.log'

    # Configuration du logger principal
    logger = logging.getLogger()
    logger.setLevel(logging.INFO)

    # Handler pour le fichier
    file_handler = logging.FileHandler(log_filename)
    file_handler.setFormatter(logging.Formatter(log_format, date_format))
    logger.addHandler(file_handler)

    # Handler pour la console avec couleurs
    class ColoredConsoleHandler(logging.StreamHandler):
        colors = {
            logging.DEBUG: '\033[94m',    # Bleu
            logging.INFO: '\033[92m',     # Vert
            logging.WARNING: '\033[93m',  # Jaune
            logging.ERROR: '\033[91m',    # Rouge
            logging.CRITICAL: '\033[95m'  # Magenta
        }
        reset = '\033[0m'

        def emit(self, record):
            try:
                color = self.colors.get(record.levelno, self.reset)
                record.msg = f'{color}{record.msg}{self.reset}'
                super().emit(record)
            except Exception:
                self.handleError(record)

    console_handler = ColoredConsoleHandler(sys.stdout)
    console_handler.setFormatter(logging.Formatter(log_format, date_format))
    logger.addHandler(console_handler)

    return logger

# Initialisation du logging au début du script
logger = setup_logging()

# Ajouter au début du fichier, juste après les imports
warnings.filterwarnings('ignore', message='urllib3 v2 only supports OpenSSL 1.1.1+')

def connect_to_db():
    try:
        db = mysql.connector.connect(
            host=NEW_DB_HOST,
            port=NEW_DB_PORT,
            user=NEW_DB_USER,
            password=NEW_DB_PASSWORD,
            database=NEW_DB_NAME
        )
        logger.info("Connexion à la base de données réussie.")
        return db
    except Exception as e:
        logger.error(f"Erreur lors de la connexion à la base de données : {str(e)}")
        return None

def remove_html_tags(text):
    clean = re.compile('<.*?>')
    return re.sub(clean, '', text)

def update_image_paths():
    db = connect_to_db()
    if db:
        cursor = db.cursor()
        try:
            # Récupérer tous les enregistrements de la table formations
            cursor.execute("SELECT id, image FROM formations")
            formations = cursor.fetchall()

            # Parcourir chaque enregistrement et mettre à jour le chemin de l'image
            for formation in formations:
                formation_id, image_path = formation
                if image_path:
                    # Remplacer l'extension de l'image par .webp
                    base_name, _ = os.path.splitext(os.path.basename(image_path))
                    new_image_path = f"assets/images/formations/{base_name}.webp"
                    cursor.execute("UPDATE formations SET image = %s WHERE id = %s", (new_image_path, formation_id))

            # Valider les modifications dans la base de données
            db.commit()
            logger.info("Les chemins d'images ont été mis à jour avec succès.")

        except Exception as e:
            # Annuler les modifications en cas d'erreur
            db.rollback()
            logger.error(f"Une erreur s'est produite lors de la mise à jour des chemins d'images : {str(e)}")

        finally:
            # Fermer la connexion à la base de données
            cursor.close()
            db.close()

def remove_html_tags_from_programme():
    db = connect_to_db()
    if db:
        cursor = db.cursor()
        try:
            # Récupérer tous les enregistrements de la table formations
            cursor.execute("SELECT id, programme FROM formations")
            formations = cursor.fetchall()

            # Parcourir chaque enregistrement et supprimer les balises HTML du champ programme
            for formation in formations:
                formation_id, programme = formation
                soup = BeautifulSoup(programme, 'html.parser')
                clean_programme = soup.get_text()
                clean_programme = clean_programme.replace('\n', '\n\n')  # Ajouter une ligne vide pour chaque saut de ligne
                cursor.execute("UPDATE formations SET programme = %s WHERE id = %s", (clean_programme, formation_id))

            # Valider les modifications dans la base de données
            db.commit()
            logger.info("Les balises HTML ont été supprimées du champ programme avec succès.")

        except Exception as e:
            # Annuler les modifications en cas d'erreur
            db.rollback()
            logger.error(f"Une erreur s'est produite lors de la suppression des balises HTML du champ programme : {str(e)}")

        finally:
            # Fermer la connexion à la base de données
            cursor.close()
            db.close()

def generate_slug(libelle):
    # Supprimer les accents et les caractères spéciaux
    slug = unidecode(libelle.lower())

    # Remplacer les espaces par des tirets
    slug = re.sub(r'[\s+]', '-', slug)

    # Supprimer les caractères non alphanumériques et les tirets en double
    slug = re.sub(r'[^a-z0-9-]', '', slug)
    slug = re.sub(r'--+', '-', slug)

    # Ajouter le suffixe "-casa"
    slug = f"{slug}-casa-rabat"

    return slug

def update_code_column():
    db = connect_to_db()
    if db:
        cursor = db.cursor()
        try:
            # Récupérer tous les enregistrements de la table formations
            cursor.execute("SELECT id, libelle FROM formations")
            formations = cursor.fetchall()

            # Parcourir chaque enregistrement et mettre à jour la colonne code
            for formation in formations:
                formation_id, libelle = formation
                code_slug = generate_slug(libelle)
                cursor.execute("UPDATE formations SET code = %s WHERE id = %s", (code_slug, formation_id))

            # Valider les modifications dans la base de données
            db.commit()
            logger.info("La colonne code a été mise à jour avec succès.")

        except Exception as e:
            # Annuler les modifications en cas d'erreur
            db.rollback()
            logger.error(f"Une erreur s'est produite lors de la mise à jour de la colonne code : {str(e)}")

        finally:
            # Fermer la connexion à la base de données
            cursor.close()
            db.close()

def truncate_tables():
    try:
        with new_db.cursor() as new_cursor:
            # Désactiver la vérification des clés étrangères
            new_cursor.execute("SET FOREIGN_KEY_CHECKS=0")

            # Vider la table 'course_modules'
            new_cursor.execute("TRUNCATE TABLE course_modules")

            # Vider la table 'courses'
            new_cursor.execute("TRUNCATE TABLE courses")

            # Vider la table 'course_faqs'
            new_cursor.execute("TRUNCATE TABLE course_faqs")

            # Réactiver la vérification des clés étrangères
            new_cursor.execute("SET FOREIGN_KEY_CHECKS=1")

            # Valider les modifications dans la nouvelle base de données
            new_db.commit()
            logger.info("Les tables 'courses', 'course_modules' et 'course_faqs' ont été vidées avec succès.")

    except Exception as e:
        # Annuler les modifications en cas d'erreur
        new_db.rollback()
        logger.error(f"Une erreur s'est produite lors du vidage des tables : {str(e)}")

def migrate_data():
    try:
        with old_db.cursor() as old_cursor, new_db.cursor() as new_cursor:
            # Récupérer les données de l'ancienne table
            old_cursor.execute("SELECT id, categorie, libelle, code, short_desc, programme, objectifs, pourqui, prerequis, pedagogique, duree, image, created_at, updated_at FROM formations")
            old_data = old_cursor.fetchall()

            for row in old_data:
                id, categorie, libelle, code, short_desc, programme, objectifs, pourqui, prerequis, pedagogique, duree, image, created_at, updated_at = row

                # Insérer les données dans la nouvelle table 'courses'
                new_cursor.execute(
                    "INSERT INTO courses (category_id, name, link, short_description, description, duration, duration_unit, objectives, target_audience, prerequisites, teaching_methods, icon_image, sidebar_image, description_image, is_certified, deleted, deleted_at, deleted_by, created_by, updated_by, created_at, updated_at) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                    (categorie, libelle, code, short_desc, short_desc, duree, "jours", objectifs, pourqui, prerequis, pedagogique, image, image, image, 0, 0, None, None, 1, 1, created_at, updated_at)
                )
                course_id = new_cursor.lastrowid

                # Insérer les données dans la nouvelle table 'course_modules'
                new_cursor.execute(
                    "INSERT INTO course_modules (course_id, title, content, created_at, updated_at) VALUES (%s, %s, %s, %s, %s)",
                    (course_id, libelle, programme, created_at, updated_at)
                )

            # Valider les modifications dans la nouvelle base de données
            new_db.commit()
            logger.info("Migration des données réussie.")

    except mysql.connector.IntegrityError as e:
        # Gérer les erreurs d'intégrité de clé unique
        if e.errno == 1062:  # Code d'erreur pour la violation de clé unique
            logger.info(f"Erreur d'intégrité de clé unique : {str(e)}")
        else:
            logger.error(f"Une erreur s'est produite lors de la migration des données : {str(e)}")
        new_db.rollback()

    except Exception as e:
        # Gérer les autres exceptions
        new_db.rollback()
        logger.error(f"Une erreur s'est produite lors de la migration des données : {str(e)}")

    finally:
        # Fermer la connexion à la base de données
        new_db.close()

class DeepSeekClient:
    """Client spécialisé pour l'API DeepSeek avec gestion avancée des erreurs"""

    def __init__(self):
        # Initialiser le logger en premier
        self.logger = logging.getLogger(__name__)
        self.request_timeout = 60  # Timeout en secondes

        # Ensuite initialiser le client
        try:
            self.client = self._initialize_client()
            self.logger.info("✅ Client DeepSeek initialisé avec succès")
        except Exception as e:
            self.logger.critical(f"❌ Échec d'initialisation du client API: {str(e)}")
            raise

    def _initialize_client(self) -> OpenAI:
        """Initialise et valide la configuration du client OpenAI"""
        api_key = os.getenv("DEEPSEEK_API_KEY")
        base_url = os.getenv("DEEPSEEK_API_URL", "https://api.deepseek.com")

        if not api_key:
            self.logger.error("❌ Clé API DeepSeek manquante dans les variables d'environnement")
            raise ValueError("Clé API DeepSeek manquante dans les variables d'environnement")

        self.logger.info(f"🔑 Initialisation du client API avec base_url: {base_url}")

        return OpenAI(
            api_key=api_key,
            base_url=base_url,
            timeout=self.request_timeout
        )

    @retry(
        stop=stop_after_attempt(3),
        wait=wait_exponential(multiplier=2, min=4, max=30),
        before_sleep=lambda retry_state: logger.info(
            f"⏳ Tentative {retry_state.attempt_number}/3 échouée, nouvelle tentative dans {retry_state.next_action.sleep} secondes..."
        )
    )
    def generate_seo_content(self, course_data: Dict[str, Any]) -> Dict[str, Any]:
        """Génère du contenu SEO optimisé via l'API OpenAI"""
        request_id = uuid.uuid4().hex[:8]
        start_time = time.time()

        try:
            self.logger.info(f"[{request_id}] 🚀 Début de la génération SEO pour: {course_data.get('name', 'Unknown')}")

            messages = self._build_seo_messages(course_data)
            self.logger.debug(f"[{request_id}] 📝 Messages préparés: {json.dumps(messages, indent=2, ensure_ascii=False)}")

            self.logger.info(f"[{request_id}] 📡 Envoi de la requête API (timeout: {self.request_timeout}s)...")

            response = self.client.chat.completions.create(
                model="gpt-4o-mini",
                messages=messages,
                temperature=0.7,
                max_tokens=2000,
                response_format={"type": "json_object"}
            )

            duration = time.time() - start_time
            self.logger.info(f"[{request_id}] ⏱️ Réponse reçue en {duration:.2f}s")

            # Validation de la réponse
            if not response.choices:
                raise APIError("Réponse API sans contenu")

            raw_content = response.choices[0].message.content
            self.logger.debug(f"[{request_id}] 📄 Contenu brut reçu: {raw_content}")

            if not raw_content or raw_content.isspace():
                raise APIError("Réponse API vide")

            try:
                content = json.loads(raw_content)
            except json.JSONDecodeError as e:
                self.logger.error(f"[{request_id}] 🔍 Contenu non-JSON reçu: '{raw_content}'")
                raise APIError(f"Format de réponse invalide: {str(e)}") from e

            # Log des métriques
            self.logger.info(
                f"[{request_id}] ✅ Succès | "
                f"Durée: {duration:.2f}s | "
                f"Tokens: {response.usage.prompt_tokens}/{response.usage.completion_tokens}"
            )

            return self._validate_seo_response(content)

        except Exception as e:
            self.logger.error(
                f"[{request_id}] ❌ Erreur lors de la génération ({type(e).__name__}): {str(e)}\n"
                f"Durée écoulée: {time.time() - start_time:.2f}s"
            )
            raise

    def _validate_seo_response(self, data: Dict) -> Dict:
        """Valide la structure de la réponse SEO"""
        if not isinstance(data, dict):
            raise ValidationError(f"Réponse invalide, attendu dict, reçu {type(data)}")

        required_fields = {
            'description': str,
            'short_description': str,
            'prerequisites': str,
            'objectives': str,
            'target_audience': str,
            'teaching_methods': str,
            'faqs': list
        }

        for field, field_type in required_fields.items():
            if field not in data:
                raise ValidationError(f"Champ manquant: {field}")
            if not isinstance(data[field], field_type):
                raise ValidationError(
                    f"Type invalide pour {field}: "
                    f"attendu {field_type.__name__}, "
                    f"reçu {type(data[field]).__name__}"
                )

        # Validation supplémentaire pour les FAQs
        for faq in data['faqs']:
            if not isinstance(faq, dict):
                raise ValidationError("Format FAQ invalide")
            if 'question' not in faq or 'answer' not in faq:
                raise ValidationError("FAQ manquante question ou réponse")
            if not isinstance(faq['question'], str) or not isinstance(faq['answer'], str):
                raise ValidationError("Types FAQ invalides")

        return data

    def _build_seo_messages(self, course_data: Dict[str, Any]) -> list:
        """Construit le prompt SEO structuré"""
        return [
            {
                "role": "system",
                "content": (
                    "Expert SEO Senior avec plus de 10 ans d'expérience pour Afrique Academy, "
                    "centre de formation et de certification professionnelle pour les entreprises basé à Casablanca, Maroc. "
                    "Nous proposons des formations adaptées aux besoins du marché pour les entreprises, "
                    "axées sur l'acquisition de compétences pratiques et certifiantes. "
                    "Générez un contenu SEO optimisé au format JSON uniquement."
                    "Votre tâche est de générer du contenu spécifique et pertinent pour chaque formation, "
                    "en vous basant strictement sur le sujet de la formation."
                ).strip()
            },
            {
                "role": "user",
                "content": f"""
                Optimisez le contenu de cette formation. Chaque élément doit être spécifique à la formation {course_data.get('name', '')}.

                Données de la formation:
                - Titre: {course_data.get('name', '')}
                - Description: {course_data.get('short_description', '')}
                - Programme: {course_data.get('description', '')}
                - Objectifs: {course_data.get('objectives', '')}
                - Public: {course_data.get('target_audience', '')}
                - Prérequis: {course_data.get('prerequisites', '')}
                - Pédagogie: {course_data.get('teaching_methods', '')}
                - Durée: {course_data.get('duration', '')} {course_data.get('duration_unit', '')}

                Format STRICT de réponse JSON:
                {{
                    "description": "Description détaillée en paragraphes fluides, sans titres ni listes. Intégrer naturellement les mots-clés SEO. Tu peux utiliser des sauts de lignes si tu veux \\n entre les paragraphes",

                    "short_description": "Résumé concis et accrocheur en un paragraphe.",

                    "prerequisites": "Premier prérequis spécifique à la formation\\n\\nDeuxième prérequis spécifique à la formation\\n\\nTroisième prérequis spécifique à la formation",

                    "objectives": "Premier objectif spécifique à la formation\\n\\nDeuxième objectif spécifique à la formation\\n\\nTroisième objectif spécifique à la formation",

                    "target_audience": "Premier public cible spécifique à la formation\\n\\nDeuxième public cible spécifique à la formation\\n\\nTroisième public cible spécifique à la formation",

                    "teaching_methods": "Première méthode pédagogique spécifique à la formation\\n\\nDeuxième méthode pédagogique spécifique à la formation\\n\\nTroisième méthode pédagogique spécifique à la formation",

                    "faqs": [
                        {{
                            "question": "Question corporate spécifique à la formatio exemple si c'est une formation Laravel, Qu'est ce que c'est Laravel ?, Quels sont les avantages de laravels par rapport a d'autres Framework ? Ai-je besoin de connaissance en php pour suivre cette formation ? Tu me comprend des questions pertinentes en rapport avec la formation ",
                            "answer": "Réponse concise et pertinente"
                        }}
                    ]
                }}

                IMPORTANT:
                - Chaque élément doit être SPÉCIFIQUE à la formation, pas de contenu générique
                - Utilisez EXACTEMENT deux retours à la ligne (\\n\\n) entre chaque élément
                - Les objectifs, prérequis, public cible et méthodes doivent être directement liés au sujet de la formation
                - Évitez tout formatage supplémentaire (pas de tirets, numéros ou autres marqueurs)
                """.strip()
            }
        ]

class APIError(Exception):
    """Exception personnalisée pour les erreurs d'API"""
    pass

class ValidationError(Exception):
    """Exception pour les erreurs de validation des données"""
    pass

# Utilisation dans le workflow principal
def optimize_course_content(course_id: int) -> bool:
    """Workflow principal d'optimisation d'un cours"""
    logger.info(f"🔍 Début d'optimisation pour le cours {course_id}")

    try:
        # 1. Récupération des données
        course_data = get_course_data(course_id)
        if not course_data:
            logger.error(f"❌ Impossible de récupérer les données du cours {course_id}")
            return False

        # 2. Génération de contenu
        seo_client = DeepSeekClient()
        logger.info(f"🎯 Optimisation du cours: {course_data['name']}")
        optimized_content = seo_client.generate_seo_content(course_data)

        # 3. Mise à jour de la base de données
        with database_transaction() as cursor:
            update_course_content(cursor, course_id, optimized_content)
            update_faqs(cursor, course_id, optimized_content['faqs'])

        logger.info(f"🎉 Cours {course_id} optimisé avec succès")
        return True

    except Exception as e:
        logger.error(f"🔥 Échec critique pour le cours {course_id}: {str(e)}")
        log_full_error(e)
        return False

def get_course_data(course_id: int) -> Optional[Dict]:
    """Récupère les données brutes du cours depuis la base de données"""
    try:
        with get_db_connection() as db:
            with db.cursor(dictionary=True) as cursor:
                cursor.execute("""
                    SELECT id, name, link, short_description, description,
                           duration, duration_unit, objectives, target_audience,
                           prerequisites, teaching_methods
                    FROM courses
                    WHERE id = %s
                """, (course_id,))
                course_data = cursor.fetchone()

                if course_data:
                    logger.info(f"📚 Données récupérées pour le cours '{course_data['name']}'")
                    return course_data
                else:
                    logger.error(f"❌ Aucune donnée trouvée pour le cours ID {course_id}")
                    return None

    except Exception as e:
        logger.error(f"📦 Erreur de récupération des données pour le cours {course_id}: {str(e)}")
        return None

@contextmanager
def database_transaction():
    """Gestionnaire de transaction SQL"""
    try:
        with new_db.cursor() as cursor:
            yield cursor
            new_db.commit()
            logger.info("💾 Transaction validée avec succès")
    except Exception as e:
        new_db.rollback()
        logger.error(f"⏮️ Rollback transaction: {str(e)}")
        raise

def log_full_error(error: Exception):
    """Log détaillé des exceptions avec traceback"""
    logger.error("".join(traceback.format_exception(
        etype=type(error), value=error, tb=error.__traceback__
    )))

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

def optimize_all_courses():
    """Optimise tous les cours avec gestion des délais entre les requêtes"""
    try:
        with get_db_connection() as db:
            with db.cursor(dictionary=True) as cursor:
                cursor.execute("""
                    SELECT id
                    FROM courses
                    WHERE id >= 139
                    ORDER BY id
                """)
                courses = cursor.fetchall()

                logger.info(f"🎯 Début de l'optimisation à partir du cours 139")
                for course in courses:
                    success = False
                    try:
                        logger.info(f"Début de l'optimisation du cours {course['id']}")
                        result = optimize_course_content(course['id'])
                        if result:
                            success = True
                            logger.info(f"Optimisation du cours {course['id']} réussie")
                        time.sleep(5)  # Pause entre chaque requête
                    except Exception as e:
                        logger.error(f"Échec de l'optimisation du cours {course['id']}: {str(e)}")
                    finally:
                        if not success:
                            logger.warning(f"L'optimisation du cours {course['id']} n'a pas abouti")

    except Exception as e:
        logger.error(f"Erreur lors de l'optimisation des cours: {str(e)}")
        raise

def verify_course_data():
    """Vérifie les données des formations dans la base de données"""
    try:
        with get_db_connection() as db:
            with db.cursor(dictionary=True) as cursor:
                cursor.execute("""
                    SELECT id, name, link, short_description, description,
                           duration, duration_unit, objectives, target_audience,
                           prerequisites, teaching_methods
                    FROM courses
                    ORDER BY id
                """)
                courses = cursor.fetchall()

                for course in courses:
                    logger.info(f"\nVérification de la formation ID {course['id']}: {course['name']}")
                    logger.info(f"Link: {course['link']}")
                    logger.info(f"Description courte: {course['short_description'][:100]}...")

                    required_fields = ['name', 'link', 'short_description', 'description']
                    for field in required_fields:
                        if not course[field]:
                            logger.warning(f"⚠️ Le champ {field} est vide pour la formation ID {course['id']}")

    except Exception as e:
        logger.error(f"Erreur lors de la vérification des données: {str(e)}")
        raise

def main():
    try:
        logger.info("🚀 Début de l'optimisation des formations")

        # Vérifier d'abord l'état actuel des formations
        verify_course_data()

        # Optimiser toutes les formations avec l'IA
        optimize_all_courses()

        logger.info("✅ Processus d'optimisation terminé")

    except Exception as e:
        logger.error(f"❌ Erreur lors de l'exécution: {str(e)}")
        log_full_error(e)

def update_course_content(cursor, course_id: int, optimized_content: Dict[str, Any]):
    """Met à jour le contenu optimisé du cours dans la base de données"""
    try:
        # Convertir les listes en texte avec sauts de ligne
        objectives = '\n\n'.join(optimized_content['objectives'])
        target_audience = '\n\n'.join(optimized_content['target_audience'])
        prerequisites = '\n\n'.join(optimized_content['prerequisites'])
        teaching_methods = '\n\n'.join(optimized_content['teaching_methods'])

        cursor.execute("""
            UPDATE courses
            SET description = %s,
                short_description = %s,
                objectives = %s,
                target_audience = %s,
                prerequisites = %s,
                teaching_methods = %s,
                updated_at = NOW()
            WHERE id = %s
        """, (
            optimized_content['description'],
            optimized_content['short_description'],
            optimized_content['objectives'],
            optimized_content['target_audience'],
            optimized_content['prerequisites'],
            optimized_content['teaching_methods'],
            course_id
        ))
        logger.info(f"✅ Contenu du cours {course_id} mis à jour")
    except Exception as e:
        logger.error(f"❌ Erreur lors de la mise à jour du cours {course_id}: {str(e)}")
        raise

def update_faqs(cursor, course_id: int, faqs: List[Dict[str, str]]):
    """Met à jour les FAQs du cours"""
    try:
        # Supprimer les FAQs existantes
        cursor.execute("DELETE FROM course_faqs WHERE course_id = %s", (course_id,))

        # Insérer les nouvelles FAQs
        for order, faq in enumerate(faqs, 1):
            cursor.execute("""
                INSERT INTO course_faqs
                (course_id, question, answer, `order`, created_at, updated_at)
                VALUES
                (%s, %s, %s, %s, NOW(), NOW())
            """, (course_id, faq['question'], faq['answer'], order))

        logger.info(f"✅ FAQs du cours {course_id} mises à jour")
    except Exception as e:
        logger.error(f"❌ Erreur lors de la mise à jour des FAQs du cours {course_id}: {str(e)}")
        raise

def fix_course_data(course_id: int, correct_data: dict):
    """Corrige les données d'une formation spécifique"""
    try:
        with new_db.cursor() as cursor:
            update_query = """
                UPDATE courses
                SET name = %s,
                    link = %s,
                    short_description = %s,
                    description = %s,
                    updated_at = NOW()
                WHERE id = %s
            """
            cursor.execute(update_query, (
                correct_data['name'],
                correct_data['link'],
                correct_data['short_description'],
                correct_data['description'],
                course_id
            ))
            new_db.commit()
            logger.info(f"✅ Formation ID {course_id} mise à jour avec succès")

    except Exception as e:
        new_db.rollback()
        logger.error(f"Erreur lors de la correction des données: {str(e)}")
        raise
    finally:
        new_db.close()

if __name__ == "__main__":
    main()

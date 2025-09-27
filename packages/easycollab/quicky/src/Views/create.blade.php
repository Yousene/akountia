<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">

    <link href="http://demo.easy-collab.com/resources/skins/prettybox/css/cus-icons.css" rel="stylesheet"/>
    <link href="http://demo.easy-collab.com/resources/skins/prettybox/css/page.css" rel="stylesheet"/>
    <link href="http://demo.easy-collab.com/resources/skins/prettybox/css/bootstrap.css" rel="stylesheet"/>
    <style type="text/css">
        select {
            margin-bottom: 0px !important;
        }

        .subFormBox {
            padding: 6px;
            border: #e4e4e4 1px solid;
            box-shadow: 0 0px 10px #DDD;
            -moz-box-shadow: 0 0px 10px #DDD;
            -webkit-box-shadow: 0 0px 10px #DDD;
            -moz-border-radius: 6px;
            border-radius: 6px;
            margin-right: 6px;
            margin-left: 6px;
        }
    </style>
    <link href="http://demo.easy-collab.com/resources/skins/prettybox/css/bootstrap-responsive.css" rel="stylesheet"/>
    <link href="http://demo.easy-collab.com/resources/skins/prettybox/css/bootstrap-modal.css" rel="stylesheet"/>

    <script src="http://demo.easy-collab.com/resources/skins/prettybox/js/jquery.min.js"></script>
    <script src="http://demo.easy-collab.com/resources/skins/prettybox/js/bootstrap.js"></script>
    <script src="http://demo.easy-collab.com/resources/skins/prettybox/js/bootstrap-modalmanager.js"></script>
    <script src="http://demo.easy-collab.com/resources/skins/prettybox//js/bootstrap-modal.js"></script>


    <script type="text/javascript" charset="utf-8">
        $('[class*="newSF"]').live('click', function () {

            if ($(this).attr('class').lastIndexOf("_") == $(this).attr('class').indexOf("_")) {
                //alert('oui');
                var classe = $(this).attr('class').substr($(this).attr('class').lastIndexOf("_") + 1);
            }

            //alert($(this).prev().attr('id'));
            //alert($(this).prev().children().length);

            //var indice=$(this).prev().children().length;


            //alert(indice);
            $("#" + classe + " div:first").clone().appendTo($(this).prev());

            //$(this).prev().children().last().css('background-color', 'red');

            var indice1 = $(this).prev().children().length - 1;
            var newClassName = 'subFormItems_' + indice1;

            $(this).prev().children().last().attr('class', newClassName);

            if ($(this).closest('[class*="subFormItems"]').attr('class') != undefined) {
                var indice = $(this).closest('[class*="subFormItems"]').attr('class').substr($(this).closest(
                    '[class*="subFormItems"]').attr('class').lastIndexOf("_") + 1);
            }

            //var indice=.($(this).closest('[class*="subFormItems"]').attr('class').lastIndexOf("_")+1);

            //alert(indice);


            //$(this).prev().children().last().css('background-color', 'red');
            //alert(classe);

            $(this).prev().children().last().find("*").each(function () {
                if ($(this).attr('name') != undefined) {
                    //alert($(this).attr('name'));
                    $(this).attr('name').replace("{i}", "" + indice);
                    //alert($(this).attr('name').replace("{i}", ""+indice));
                    var newName = $(this).attr('name').replace("{i}", "" + indice);
                    $(this).attr('name', newName);
                }
            });

        });

        $(".delBlock").live('click', function () {
            $(this).next().attr('value', 1);
            $(this).closest('[class*="subFormItems"]').css('display', 'none');
            //knt dayer flwal parents o apres bdeltha l closest  parents tatjib lik ga3 les elements parents li jayn m3a lfiltre closest tat3tek rir awal wahd
            //$(this).parents('.subFormItems ').css('display','none');
        });


        $(".inGrid").live('change', function () {
            ($(this).is(':checked')) ? $(this).next().attr('value', 1) : $(this).next().attr('value', 0);
        });

        $("select").live('change', function () {
            //alert( this.value );
            //$(this).parents('table .subFormTable').next().append(this.value);
            var selected = this.value;
            //$(this).parents('table .subFormTable').next().children().each(function () {
            $(this).closest('table').next().children().each(function () {

                //alert($(this).attr('id'));
                if ($(this).attr('class') == selected + '_content')
                    $(this).css('display', 'block');
                else
                    $(this).css('display', 'none');
            });

        });

        function CapitaliseFirstLetter(elementId) {
            var txt = $("#" + elementId).val().toLowerCase();
            $("#" + elementId).val(txt.replace(/^(.)|\s(.)/g, function ($1) {
                return $1.toUpperCase();
            }));
        }


        function showcontroller() {
            ($("#controllerName").css("display") == "none") ? $("#controllerName").css("display", "inline-block") : $(
                "#controllerName").css("display", "none");
        }

        // $(document).ready(function () {

        //     $('#projetid').on('blur', function () {
        //         var projectName = $(this).val();
        //         $.ajax({
        //             url: '/check-project/' + projectName,
        //             type: 'GET',
        //             success: function (data) {
        //                 if (data.exists) {
        //                     alert('The project already exists.');
        //                     // Clear all input fields
        //                     $(':input').each(function () {
        //                         if (this.type === 'text') {
        //                             $(this).val('');
        //                         }
        //                     });
        //                 }
        //             },
        //             error: function (jqXHR, textStatus, errorThrown) {
        //                 console.error(errorThrown);
        //             }
        //         });
        //     });
        // });

    </script>


</head>

<body>
<div id="page-wrapper">
    <form method="POST">
        <div id="page-content">
            <div id="header-wrapper">

                <div class="button-wrapper">
                    <button class="btn" type="reset"><i class="cus-arrow-refresh"></i> Réinitialiser le
                        formulaire
                    </button>
                    <button class=" btn " type="Submit"><i class="cus-disk"></i> Sauvegarder</button>
                </div>
            </div>
            <div id="body-container">
                <table width=100%">
                    <tr>
                        <td class="left-column" valign="top">
                            <div id="div_add" class="pm-bxm-box">
                                <div class="box-title-wrapper box-title-blue">
                                    <div class="box-title">
                                        <h3>Nouvelle application Quicky</h3>
                                    </div>
                                </div>
                                <div class="tabbable" style="margin-left: 18px;">
                                    <table width="100%">
                                        <tr>
                                            <td width="15%" height="37">
                                                Nom projet
                                                :
                                            </td>
                                            <td width="85%">
                                                <input onChange="CapitaliseFirstLetter('projetid')" ; type="text"
                                                       id="projetid" name="projetid" style="width: 90%;">
                                            </td>
                                        </tr>

                                        <tr>
                                            <td width="15%" height="37">
                                                ID du projet
                                                :
                                            </td>
                                            <td width="85%">
                                                <input onChange="CapitaliseFirstLetter('projet')" ; type="text"
                                                       id="projet" name="projet" style="width: 90%;">
                                            </td>
                                        </tr>

                                        <tr>
                                            <td width="15%" height="37">
                                                Nombre de colonnes
                                                :
                                            </td>
                                            <td width="85%">
                                                <select name="colNumber">
                                                    <option value="12">1</option>
                                                    <option value="6" selected>2</option>
                                                    <option value="4">3</option>
                                                    <option value="3">4</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="15%" height="37">Déscription :</td>
                                            <td width="85%"><textarea style="width: 90%;" name="desc"> </textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                serverSide : <input type='checkbox' class="inGrid" checked="checked">
                                                <input type="hidden" name="serverSide" value="1" class="hide">
                                            </td>
                                        </tr>


                                    </table>
                                    <br>
                                    <table width="100%">
                                        <tr>

                                            <td>
                                                <div class="subForm_container">

                                                </div>
                                                <a href="javascript:void(0);" class="newSF_subForm"> <i
                                                        class=" cus-add"></i> Ajouter un composant </a>
                                                <!-- <a href="javascript:void(0);"  onclick="add()"  > <i class=" cus-add"></i>  ajouter </a> -->
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </td>

                    </tr>
                </table>


            </div>
        </div>
    </form>
    <div id="static" class="modal hide fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-body">
            <p>Etes vous sûr de vouloir supprimer cette demande ?</p>
        </div>
        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn"><i class="cus-arrow-left"></i> Annuler</button>
            <button type="button" data-dismiss="modal" onClick="loadingModal(1000)" class="btn btn-danger"><i
                    class="cus-exclamation"></i> Supprimer
            </button>
        </div>
    </div>

    <div class="hide" id="subFormSelect">
        <div class="subFormItems" style="margin-bottom: 10px;">
            <table>
                <tr>
                    <td>
                        <input type='text' size='50' name="Select_cle[{i}][]" placeholder="Clé" style="width:30px;">
                    </td>
                    <td>
                        <input type='text' size='50' name="Select_valeur[{i}][]" placeholder="Valeur">
                    </td>
                    <td style="cursor: pointer;">
                        <a class="delBlock">
                            <i class=" cus-delete"></i>
                        </a>
                        <input type="hidden" name="Select_del[{i}][]" value="0" class="hide">
                    </td>
                </tr>
            </table>
        </div>
    </div>


    <div class="hide" id="subForm">

        <div class="subFormItems" style="margin-bottom: 6px;">
            <div class="subFormBox">
                <table width="100%" style="margin-bottom: 4px;">
                    <tr>
                        <td>
                            <input type='text' name="Identifiant[]" size='50' placeholder="Identifiant">
                        </td>
                        <td>
                            <input type='text' name="Label[]" size='50' placeholder="Label">
                        </td>
                        <td>
                            <select name="formElement[]">
                                <option value="?">Choisir un type</option>
                                <option value="primary_key">Primary Key</option>
                                <option value="secondary_key">Secondary Key</option>
                                <option value="text">Text</option>
                                <option value="select">Select</option>
                                <option value="select_basic">Basic Select</option>
                                <option value="select_multiple">Select Multiple</option>
                                <option value="select_multiple_basic">Basic Select Multiple</option>
                                <option value="textarea">Textarea</option>
                                <option value="ckeditor">Wysiwyg (CKEditor)</option>
                                <option value="radio">Radio</option>
                                <option value="checkbox">Checkbox</option>
                                <option value="datepicker">Datepicker</option>
                                <option value="timepicker">Timepicker</option>
                                <option value="colorpicker">Colorpicker</option>
                                <option value="file">File</option>
                                <option value="phone">Phone</option>
                                <option value="hidden">Hidden</option>
                            </select>
                        </td>
                        <td>
                            <input type='text' name="size[]" size='50' placeholder="size" style="width:30px;">
                        </td>
                        <td>
                            Required : <input type='checkbox' name="visible[]" checked="checked">
                        </td>
                        <td>
                            inGrid : <input type='checkbox' class="inGrid" checked="checked">
                            <input type="hidden" name="inGrid[]" value="1" class="hide">
                        </td>

                        <td style="cursor: pointer;">
                            <a class="delBlock">
                                <i class=" cus-delete"></i>
                            </a>
                            <input type="hidden" name="del[]" value="0" class="hide">

                        </td>
                    </tr>
                </table>
                <div id="dd">
                    <div class="secondary_key_content" style="display: none;">
                        <table>
                            <tr>
                                <td>
                                    <input type='text' name="skmodel[]" placeholder="Modèle">
                                </td>
                                <td>
                                    <input type='text' name="skkey[]" style="width:30px;" placeholder="Clé">
                                </td>
                                <td>
                                    <input type='text' name="skvalue[]" placeholder="Valeur">
                                </td>
                                <td>
                                    <select name="sktype[]" disabled style="margin-bottom: 10px !important;">
                                        <option value="select">Select</option>
                                        <option value="select_basic">Basic Select</option>
                                        <option value="select_multiple">Select Multiple</option>
                                        <option value="select_multiple_basic">Basic Select Multiple</option>
                                        <option value="radio">Radio</option>
                                        <option value="checkbox">Checkbox</option>
                                    </select>
                                </td>
                            </tr>
                        </table>

                    </div>
                    <div class="select_content" style="display: none;">
                        <div></div>
                        <a href="javascript:void(0);" class="newSF_subFormSelect"> <i class=" cus-add"></i> Ajouter
                            un element de la liste Select</a>
                    </div>
                    <div class="select_basic_content" style="display: none;">
                        <div></div>
                        <a href="javascript:void(0);" class="newSF_subFormSelectBasic"> <i class=" cus-add"></i>
                            Ajouter un element de la liste Basic Select</a>
                    </div>
                    <div class="select_multiple_content" style="display: none;">
                        <div></div>
                        <a href="javascript:void(0);" class="newSF_subFormSelectMultiple"> <i class=" cus-add"></i>
                            Ajouter un element de la liste Select Multiple</a>
                    </div>
                    <div class="select_multiple_basic_content" style="display: none;">
                        <div></div>
                        <a href="javascript:void(0);" class="newSF_subFormSelectMultipleBasic"> <i
                                class=" cus-add"></i> Ajouter un element de la liste Select Multiple Basic</a>
                    </div>
                    <div class="radio_content" style="display: none;">
                        <div></div>
                        <a href="javascript:void(0);" class="newSF_subFormRadio"> <i class=" cus-add"></i> Ajouter
                            un element de la liste Radio</a>
                    </div>
                    <div class="checkbox_content" style="display: none;">
                        <div></div>
                        <a href="javascript:void(0);" class="newSF_subFormCheckbox"> <i class=" cus-add"></i>
                            Ajouter un element de la liste Checkbox</a>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <div class="hide" id="subFormSelect">
        <div class="subFormItems" style="margin-bottom: 10px;">
            <table>
                <tr>
                    <td>
                        <input type='text' size='50' name="Select_cle[{i}][]" placeholder="Clé" style="width:30px;">
                    </td>
                    <td>
                        <input type='text' size='50' name="Select_valeur[{i}][]" placeholder="Valeur">
                    </td>
                    <td style="cursor: pointer;">
                        <a class="delBlock">
                            <i class=" cus-delete"></i>
                        </a>
                        <input type="hidden" name="Select_del[{i}][]" value="0" class="hide">
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div class="hide" id="subFormSelectBasic">
        <div class="subFormItems" style="margin-bottom: 10px;">
            <table>
                <tr>
                    <td>
                        <input type='text' size='50' name="Select_basic_cle[{i}][]" placeholder="Clé"
                               style="width:30px;">
                    </td>
                    <td>
                        <input type='text' size='50' name="Select_basic_valeur[{i}][]" placeholder="Valeur">
                    </td>
                    <td style="cursor: pointer;">
                        <a class="delBlock">
                            <i class=" cus-delete"></i>
                        </a>
                        <input type="hidden" name="Select_basic_del[{i}][]" value="0" class="hide">
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div class="hide" id="subFormSelectMultipleBasic">
        <div class="subFormItems" style="margin-bottom: 10px;">
            <table>
                <tr>
                    <td>
                        <input type='text' size='50' name="Select_multiple_basic_cle[{i}][]" placeholder="Clé"
                               style="width:30px;">
                    </td>
                    <td>
                        <input type='text' size='50' name="Select_multiple_basic_valeur[{i}][]"
                               placeholder="Valeur">
                    </td>
                    <td style="cursor: pointer;">
                        <a class="delBlock">
                            <i class=" cus-delete"></i>
                        </a>
                        <input type="hidden" name="Select_multiple_basic_del[{i}][]" value="0" class="hide">
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div class="hide" id="subFormSelectMultiple">
        <div class="subFormItems" style="margin-bottom: 10px;">
            <table>
                <tr>
                    <td>
                        <input type='text' size='50' name="Select_multiple_cle[{i}][]" placeholder="Clé"
                               style="width:30px;">
                    </td>
                    <td>
                        <input type='text' size='50' name="Select_multiple_valeur[{i}][]" placeholder="Valeur">
                    </td>
                    <td style="cursor: pointer;">
                        <a class="delBlock">
                            <i class=" cus-delete"></i>
                        </a>
                        <input type="hidden" name="Select_multiple_del[{i}][]" value="0" class="hide">
                    </td>
                </tr>
            </table>
        </div>
    </div>


    <div class="hide" id="subFormRadio">
        <div class="subFormItems" style="margin-bottom: 10px;">
            <table>
                <tr>
                    <td>
                        <input type='text' size='50' name="Radio_cle[{i}][]" placeholder="Clé" style="width:30px;">
                    </td>
                    <td>
                        <input type='text' size='50' name="Radio_valeur[{i}][]" placeholder="Valeur">
                    </td>
                    <td style="cursor: pointer;">
                        <a class="delBlock">
                            <i class=" cus-delete"></i>
                        </a>
                        <input type="hidden" name="Radio_del[{i}][]" value="0" class="hide">
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div class="hide" id="subFormCheckbox">
        <div class="subFormItems" style="margin-bottom: 10px;">
            <table>
                <tr>
                    <td>
                        <input type='text' size='50' name="Checkbox_cle[{i}][]" placeholder="Clé"
                               style="width:30px;">
                    </td>
                    <td>
                        <input type='text' size='50' name="Checkbox_valeur[{i}][]" placeholder="Valeur">
                    </td>
                    <td style="cursor: pointer;">
                        <a class="delBlock">
                            <i class=" cus-delete"></i>
                        </a>
                        <input type="hidden" name="Checkbox_del[{i}][]" value="0" class="hide">
                    </td>
                </tr>
            </table>
        </div>
    </div>


    <script type="text/javascript" charset="utf-8"
            src="http://demo.easy-collab.com/resources/skins/prettybox/js/page.js"></script>

</body>

</html>

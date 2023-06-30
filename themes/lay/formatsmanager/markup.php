<div class="wrap">
    <h2>Text Formats</h2>


        <?php if(isset( $_GET['settings-updated'])) { ?>
        <div class="updated">
            <p>Text Formats updated.</p>
            <?php
                FormatsManager::updateCustomizerStylesLinkedWithTextformats();
            ?>
        </div>
        <?php }
            ?>
            <div class="lay-explanation <?php echo get_option('expand-what_are_text_formats', 'expanded'); ?>" data-expand-status-option-name="expand-what_are_text_formats">
                <header>
                    <h3 class="title">What are Text Formats?</h3>
                    <button class="lay-explanation-handle"></button>
                </header>
                <div class="lay-explanation-inner">
                    <p>
                        Predefine Text Formats (styles) below and use them on any texts.
                        To have a consistent look, use them in Projects, Pages and the Customizer.
                    </p>
                    <p>
                        Example: Create a Text Format. Apply it to your menu in the Customizer. Edit the format here &#8594; the menu text style changed too.<br>
                    </p>
                    <p>
                        <strong>By default, the "Default" format is in use everywhere. Give it a try and change it!</strong></span>
                    </p>
                    <ul>
                        <li>Define spaces above and below your paragraphs with "Space Top" and "Space Bottom"</li>
                        <li>The code of your site will be much cleaner</li>
                        <li>Set extra styles for the phone view like "Phone Font Size", "Phone Space Top", "Phone Space Bottom"</li>
                        <li>Supports webfonts! Upload them <a href="<?php echo admin_url( 'admin.php?page=manage-webfonts' ); ?>">here</a></li>
                    </ul>
                </div>
            </div>
            <div class="lay-explanation <?php echo get_option('expand-how_to_use_text_formats', 'expanded'); ?>" data-expand-status-option-name="expand-how_to_use_text_formats">
                <header>
                    <h3 class="title">How to use</h3>
                    <button class="lay-explanation-handle"></button>
                </header>
                <div class="lay-explanation-inner">
                    <h3 class="title">Step 1: Create a new Format</h3>
                    <p>
                        Choose a Format Type below and type in a Format Name. Optionally choose an existing format to create a copy of it. Then click on <span class="lay-label label-info">Add Format</span>. Note that once a format is created you can't change its name.
                         Edit the format until you're happy, then click <span class="lay-label label-info">Save Changes</span>.
                    </p>
                    <p>
                        Paragraph and Headline formats can only be applied to blocks of text. Character formats can be used for words within a block of text.
                    </p>
                    <h3 class="title">Step 2: Usage</h3>
                    <p>
                        Your Text Formats will appear in the "Formats" dropdown menu when you edit texts in "Projects" and "Pages".<br> If you apply your Text Format and it does not look right try this: Select your text, click <img style="vertical-align:middle; border:1px solid #ddd; border-radius:3px;" src="<?php echo get_template_directory_uri().'/gridder/assets/img/textmodal_notices/clear_formatting.png'; ?>" alt=""> "Clear formatting", then re-apply your Text Format.
                    </p>
                    <p>
                        In the Customizer your formats show up in the "Text Format" dropdown menus for Site Title, Menu and Project Title.
                    </p>
                </div>
            </div>

            <div id="formatsmanager"></div>

    <form method="post" action="options.php">

        <?php settings_fields( 'admin-textformats-settings' ); ?>
        <?php do_settings_sections( 'admin-textformats-settings' ); ?>
        <textarea id="formatsmanager_json" name="formatsmanager_json"><?php echo FormatsManager::getDefaultFormatsJson(); ?></textarea><br>
        <textarea id="fontmanager_json" name="fontmanager_json"><?php echo get_option('fontmanager_json'); ?></textarea>
        <?php submit_button(); ?>
    </form>
</div>
<?php
echo
'<script type="text/template" id="row-composite-view">
    <div class="panel panel-default formatsmanager-panel">
      <table class="table font-table table-bordered js-formats-table" id="textformats-table">
      </table>
      <div class="panel-footer clearfix">
        <table class="table-condensed pull-right">
            <tr>
                <td>Add a Format of type</td>
                <td>
                    <select class="js-format-type">
                        <option value="Paragraph">Paragraph</option>
                        <option value="Headline">Headline</option>
                        <option value="Character">Character</option>
                    </select>
                </td>
                <td>named</td>
                <td>
                    <input placeholder="Format Name" class="js-format-name-input format-name-input" data-parsley-type="alphanum" data-parsley-isother data-parsley-errors-messages-disabled type="text">
                </td>
                <td>by making a copy of</td>
                <td>
                    <select class="js-copy-formats copy-formats-input">';

                        echo '<option value="">--SELECT--</option>';

                        $customFormats = FormatsManager::$customFormats;
                        $style_formats = array();

                        if($customFormats){
                            for($i=0; $i<count($customFormats); $i++){
                                echo '<option value="'.$customFormats[$i]['formatname'].'">'.$customFormats[$i]['formatname'].'</option>';
                            }
                        }

                    echo
                    '</select>
                </td>
                <td>
                    <button type="button" disabled="disabled" class="btn btn-info js-add-format btn-sm"><span class="glyphicon glyphicon-plus"></span> Add Format</button>
                </td>
            </tr>
        </table>

      </div>
    </div>
</script>

<!-- letter spacing values taken from gridder->tinymce-plugins->letterspacing -->
<!-- line height values taken from gridder->tinymce-plugins->lineheight -->
<script type="text/template" id="row-view">
    <tr class="textformat-collapsable">
        <th colspan="2" class="js-format-name info" data-name="<%= showFormatName() %>">
            <span class="format-name-text-wrap">
                <span class="drag-icon"></span>
                <span class="expand-arrow"></span>
                <span class="format-name"><%= showFormatName() %></span> <span class="format-type-indicator"> type: <%= showFormatType() %></span><span class="format-html-class">HTML Class: _<%= showFormatName() %></span>
            </span>
            <button type="button" style="<%= deleteCSS() %>" class="pull-right btn btn-default btn-sm js-delete-row delete-format-row btn-block"><span class="glyphicon glyphicon-trash"></span> Delete</button>
        </th>
    </tr>
    <tr class="row-wrap">
        <td class="format">
            <table class="table-condensed attributes-table" data-type="<%= showFormatType() %>">
                <tr class="textformat-type-row">
                    <td>Format Type</td>
                    <td>
                        <select class="js-existing-format-type-select">
                            <option value="Paragraph">Paragraph</option>
                            <option value="Headline">Headline</option>
                            <option value="Character">Character</option>
                        </select>
                    </td>
                </tr>
                <tr class="headline-type-row">
                    <td>Headline Type</td>
                    <td>
                        <select class="js-headline-type-select">
                            <option value="h1">H1</option>
                            <option value="h2">H2</option>
                            <option value="h3">H3</option>
                            <option value="h4">H4</option>
                            <option value="h5">H5</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Font Family</td>
                    <td>
                        <select class="font-select">';
                            echo '<option value="">--SELECT--</option>';
                            if (is_array(FontManager::$customFonts)) {
                              for($i=0; $i<count(FontManager::$customFonts); $i++){
                                if(FontManager::$customFonts[$i]){
                                    $value;
                                    if(array_key_exists('type', FontManager::$customFonts[$i]) && FontManager::$customFonts[$i]['type'] == "link" ||
                                        array_key_exists('type', FontManager::$customFonts[$i]) && FontManager::$customFonts[$i]['type'] == "script"){
                                        $value = FontManager::$customFonts[$i]['css'];
                                        $value = str_replace('font-family: ', '', $value);
                                        $value = str_replace('font-family:', '', $value);
                                        $value = str_replace(';', '', $value);
                                    }
                                    else{
                                        $value = FontManager::$customFonts[$i]['fontname'];
                                    }
                                    echo '<option value="'.$value.'">'.FontManager::$customFonts[$i]['fontname'].'</option>';
                                }
                              }
                            }
                            foreach (FontManager::$originalFonts as $key => $value) {
                                echo '<option value="'.$value.'">'.$key.'</option>';
                            }
                        echo
                        '</select>
                    </td>
                </tr>
                <tr>
                    <td>Font Size</td>
                    <td>
                        <input type="number" class="font-size" value="16" step="0.1" min="1" max="<?php echo Gridder::$maxFontsize ?>">
                        <select class="font-size-mu">
                            <option value="px">px</option>
                            <option value="vw">%</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Color</td>
                    <td><div class="js-color-rectangle color-rectangle"></div><input type="text" class="colorpicker"></td>
                </tr>
                <tr class="variable-font-instances-region"></tr>
                <tr class="variable-font-axes-region"></tr>
                <tr>
                    <td>Font Weight</td>
                    <td>
                        <select class="font-weight-select">';

                        foreach (FormatsManager::$fontWeights as $key => $value) {
                            echo '<option value="'.$value.'">'.$key.'</option>';
                        }

                        echo
                        '</select>
                    </td>
                </tr>
                <tr class="font-style-row">
                    <td>Font Style</td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            <button type="button" class="btn btn-default btn-sm js-font-style-italic">
                                <span style="font-style:italic;font-weight:800;">I</span>
                            </button>
                            <button type="button" class="btn btn-default btn-sm js-font-style-underline">
                                <span style="text-decoration:underline;font-weight:800;">U</span>
                            </button>
                            <button type="button" class="btn btn-default btn-sm js-font-style-border-bottom">
                                <span style="border-bottom:1px solid black;font-weight:800;">U</span>
                            </button>
                            <button type="button" class="btn btn-default btn-sm js-font-style-caps">
                                <span style="font-family:serif;font-weight:800;">TT</span>
                            </button>
                            <!-- <button type="button" class="btn btn-default btn-sm js-font-style-strikethrough">
                                <span style="text-decoration:line-through;font-weight:800;">S</span>
                            </button> -->
                        </div>
                    </td>
                </tr>
                <tr class="line-height-row">
                    <td>Line Height</td>
                    <td><input type="number" class="line-height" value="1.2" step="0.1" min="0.6" max="2.5"></td>
                </tr>
                <tr class="text-indent-row">
                    <td>Text Indent</td>
                    <td><div class="input-group"><input type="number" class="text-indent" value="0" step="0.1" min="0"><span class="lay-textformats-input-group-addon">em</span></div></td>
                </tr>
                <tr>
                    <td>Letter Spacing</td>
                    <td><div class="input-group"><input type="number" class="letter-spacing" value="0" step="0.01"><span class="lay-textformats-input-group-addon">em</span></div></td>
                </tr>
                <tr class="text-align-row">
                    <td>Text Align</td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            <button type="button" data-align="left" class="btn btn-default btn-sm align-js active">
                                <span class="glyphicon glyphicon-align-left"></span>
                            </button>
                            <button type="button" data-align="center" class="btn btn-default btn-sm align-js">
                                <span class="glyphicon glyphicon-align-center"></span>
                            </button>
                            <button type="button" data-align="right" class="btn btn-default btn-sm align-js">
                                <span class="glyphicon glyphicon-align-right"></span>
                            </button>
                            <button type="button" data-align="justify" class="btn btn-default btn-sm align-js">
                                <span class="glyphicon glyphicon-align-justify"></span>
                            </button>
                        </div>
                    </td>
                </tr>
                <tr class="space-top-row">
                    <td>Space Top</td>
                    <td>
                        <input type="number" class="space-top" value="0" step="1" min="0" max="200">
                        <select class="space-top-mu">
                            <option value="px">px</option>
                            <option value="vw">%</option>
                        </select>
                    </td>
                </tr>
                <tr class="space-bottom-row">
                    <td>Space Bottom</td>
                    <td>
                        <input type="number" class="space-bottom" value="0" step="1" min="0" max="200">
                        <select class="space-bottom-mu">
                            <option value="px">px</option>
                            <option value="vw">%</option>
                        </select>
                    </td>
                </tr>';
if(FormatsManager::$hasTabletSettings){
echo
                '<tr class="tablet-font-size-row">
                    <td>Tablet Font Size</td>
                    <td>
                        <input type="number" class="tablet-font-size" value="25" step="0.1" min="1" max="<?php echo Gridder::$maxFontsize ?>">
                        <select class="tablet-font-size-mu">
                            <option value="px">px</option>
                            <option value="vw">%</option>
                        </select>
                    </td>
                </tr>
                <tr class="tablet-space-top-row">
                    <td>Tablet Space Top</td>
                    <td><input type="number" class="tablet-space-top" value="0" step="1" min="0" max="200">
                    <select class="tablet-space-top-mu">
                        <option value="px">px</option>
                        <option value="vw">%</option>
                    </select></td>
                </tr>
                <tr class="tablet-space-bottom-row">
                    <td>Tablet Space Bottom</td>
                    <td><input type="number" class="tablet-space-bottom" value="0" step="1" min="0" max="200">
                    <select class="tablet-space-bottom-mu">
                        <option value="px">px</option>
                        <option value="vw">%</option>
                    </select></td>
                </tr>';
                }
echo
                '<tr class="phone-font-size-row">
                    <td>Phone Font Size</td>
                    <td>
                        <input type="number" class="phone-font-size" value="16" step="0.1" min="1" max="<?php echo Gridder::$maxFontsize ?>">
                        <select class="phone-font-size-mu">
                            <option value="px">px</option>
                            <option value="vw">%</option>
                        </select>
                    </td>
                </tr>
                <tr class="phone-space-top-row">
                    <td>Phone Space Top</td>
                    <td><input type="number" class="phone-space-top" value="0" step="1" min="0" max="200">
                    <select class="phone-space-top-mu">
                        <option value="px">px</option>
                        <option value="vw">%</option>
                    </select></td>
                </tr>
                <tr class="phone-space-bottom-row">
                    <td>Phone Space Bottom</td>
                    <td><input type="number" class="phone-space-bottom" value="0" step="1" min="0" max="200">
                    <select class="phone-space-bottom-mu">
                        <option value="px">px</option>
                        <option value="vw">%</option>
                    </select></td>
                </tr>
            </table>
        </td>
        <td class="format-preview-wrap">
            <div class="format-preview">
                <span class="preview-type">Desktop:</span>
                <div class="space-top-preview js-desktop-spacetop" <%= getSpaceTopStyleDesktop() %>></div>

                <div class="js-desktop-style js-style" contentEditable="true" spellcheck="false" style="<%= getStyleDesktop() %>">
                    <%= showText() %>
                </div>

                <div class="space-bottom-preview js-desktop-spacebottom" <%= getSpaceBottomStyleDesktop() %>></div>
            </div>';
if(FormatsManager::$hasTabletSettings){
echo
            '<div class="format-preview">
                <span class="preview-type">Tablet:</span>
                <div class="space-top-preview js-tablet-spacetop" <%= getSpaceTopStyleTablet() %>></div>

                <div class="js-tablet-style js-style" contentEditable="true" spellcheck="false" style="<%= getStyleTablet() %>">
                     <%= showText() %>
                </div>

                <div class="space-bottom-preview js-tablet-spacebottom" <%= getSpaceBottomStyleTablet() %>></div>
            </div>';
}
echo
            '<div class="format-preview">
                <span class="preview-type">Phone:</span>
                <div class="space-top-preview js-phone-spacetop" <%= getSpaceTopStylePhone() %>></div>

                <div class="js-phone-style js-style" contentEditable="true" spellcheck="false" style="<%= getStylePhone() %>">
                     <%= showText() %>
                </div>

                <div class="space-bottom-preview js-phone-spacebottom" <%= getSpaceBottomStylePhone() %>></div>
            </div>
        </td>
    </tr>
</script>';

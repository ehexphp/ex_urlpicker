<?php
/**
 * Created by PhpStorm.
 * User: samtax
 * Date: 01/12/2018
 * Time: 3:03 PM
 */



/**
 *
 * Class exUrlPicker
 */
class exUrlPicker{


    /**
     * Assign Picker to Button and Call back Input Field
     * @param string $clickButtonId
     * @param string $inputId
     * @param null $filePreviewId
     * @return string
     */
    function add($clickButtonId = 'btn_url_manager', $inputId = 'file', $filePreviewId = null){
        echo "<script>   document.getElementById('$clickButtonId').onclick = function(){ exumButtonOnClick('$inputId', '$filePreviewId') }; </script>";
        return $this;
    }



    function addField($inputName = 'file', $initFileUrl = null, $inputAttribute = array(), $labelName = 'Select Image', $style = 'margin-bottom:5px;'){ ?>
        <span>
            <span style="display: inline-block;<?=$style?>">
                <label class="ex_picker_widget btn btn-default" style="height:150px;width:150px;overflow: auto"  onclick="exumButtonOnClick(null, null, this)"><!-- class="form-control" style="height:100px;width:100%;display: none;" name="< ?= $inputName ?>" -->
                    <textarea <?= Array1::toHtmlAttribute($inputAttribute, ['class'=>'form-control', 'style'=>'height:100px;width:100%;display: none;', 'name'=>$inputName]) ?> ><?= $initFileUrl ?></textarea>
                    <img style="height:100px;width:100%;"  src="<?= Url1::getFileImagePreview($initFileUrl) ?>">
                    <span style="margin-top:10px;display: block"><i class="fa fa-upload"></i> <?= $labelName ?> </span>
                </label>
                <label class="btn btn-default" style="width:100%;display: block"><input onchange="Html1.toggleDisplayStyle(this, this.parentNode.parentNode.parentNode.querySelector('img')); Html1.toggleDisplayStyle(this, this.parentNode.parentNode.parentNode.querySelector('textarea'), true)" type="checkbox" /> Show Url</label>
            </span>
        </span>
        <?php return $this;
    }


    /**
     * @param string $inputName
     * @param string $initFileUrl
     * @param string $labelName
     * @param string $containerStyle
     * @param array $inputAttribute
     * @return exFilePicker
     */
function addMoreButton($inputName = 'file', $initFileUrl = '', $inputAttribute = array(), $labelName = 'Select Image', $containerStyle = 'margin-bottom:15px;'){
    $uniqueId = Math1::getUniqueId();
    ob_start(); echo $this->addField($inputName, $initFileUrl,$inputAttribute,  $labelName, $containerStyle); $initData = ob_get_clean();
    echo "<span id='ex_up_addMore_con_{$uniqueId}'></span>"; ?>
    <script> function ex_up_addMore_<?=$uniqueId?>(){ let container = $('#ex_up_addMore_con_<?=$uniqueId?>'); container.append( `<?= $initData ?>` ); } </script>
    <?php
     echo "<br/><button type='button' onclick='ex_up_addMore_{$uniqueId}()' class='btn btn-success' style='margin:5px 0 10px 0; padding: 3px 18px 6px 5px; border-radius:50px;'><span class='fa fa-plus-circle text-success' ></span> Add More </button><br/>"; return $this;
 }

















    /**
     * @return string
     */
    public function __toString() { return ''; }


    /**
     * @param int $search_limit
     * @param null $urlController
     * @param null $model
     */
     function __construct($search_limit = -1, $urlController = null, $model = null){
        $initOption = "?token=".token().($model? "&model_name=".$model->getModelClassName()."&model_id=$model->id": '');
        $file_fetch_controller = Form1::callApi("exUrlPickerController::fetch()$initOption&as_thumb=true");
        $save_url_controller = Form1::callApi("exUrlPickerController::saveUrl()$initOption");

        $file_search_controller = Form1::callApi(($urlController?$urlController:"exUrlPickerController::search()"). "$initOption&as_thumb=true&search_limit=$search_limit");
        $style = HtmlStyle1::enable3DButton('.btn3d');
        $defaultImage = current_plugin_asset('images/file.png');
        $defaultSuccessImage = current_plugin_asset('images/success.png');
        $theme_button_class = String1::replace(HtmlForm1::$THEME_BUTTON_CLASS, 'btn-lg', '');
       // $plugin_asset = current_plugin_asset();
        $loading= HtmlWidget1::loader('#1886BA');
        $addUrlBox = HtmlForm1::addInput('Url', ['id'=>'ex_up_new_url', 'onkeyup'=>' document.getElementById(`ex_up_new_url_name`).value = FileManager1.getFileName(this.value)']).HtmlForm1::addInput('Url Name (optional)', ['id'=>'ex_up_new_url_name']).'<button onclick="exUrlPickerSaveNewUrl()" class="'.$theme_button_class.'primary" style="padding:10px;margin:5px 0;"><i class="fa fa-plus" aria-hidden="true"></i> Add</button>';
        

        echo <<<HTML
        <!-- Modal -->
        <style>.ex_url_manager_modal{display:none;position:fixed;z-index:1;padding-top:100px;left:0;top:0;width:100%;height:100%;overflow:auto;background-color:#000;background-color:rgba(0,0,0,0.4)}.ex_url_manager_modal-content{position:relative;background-color:#fefefe;margin:auto;padding:0;border:1px solid #888;width:80%;box-shadow:0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);-webkit-animation-name:animatetop;-webkit-animation-duration:.4s;animation-name:animatetop;animation-duration:.4s}@-webkit-keyframes animatetop{from{top:-300px;opacity:0}to{top:0;opacity:1}}@keyframes animatetop{from{top:-300px;opacity:0}to{top:0;opacity:1}}.ex_url_manager_btn_close{color:white;float:right;font-size:28px;font-weight:bold}.ex_url_manager_btn_close:hover,.ex_url_manager_btn_close:focus{color:#000;text-decoration:none;cursor:pointer}.ex_url_manager_modal-header{padding:2px 10px;background-color:#1f6685;color:white}.ex_url_manager_modal-footer{padding:2px 10px;background-color:#F1F1F1;color:white}</style>
        <!-- Tab -->
        <style>.ex_url_manager_tab{overflow:hidden;border:1px solid #ccc;background-color:#f1f1f1}.ex_url_manager_tab button{background-color:inherit;float:left;border:0;outline:0;cursor:pointer;padding:12px 12px;transition:.3s;font-size:15px}.ex_url_manager_tab button:hover{background-color:#ddd}.ex_url_manager_tab button.active{background-color:#ccc}.ex_url_manager_tabcontent{display:none;padding:6px 12px;border:1px solid #ccc;border-top:0;min-height:100px}.ex_url_manager_tab_topright{float:right;cursor:pointer;font-size:28px}.ex_url_manager_tab_topright:hover{color:red}</style>
        
        
    
        <!-- The ex_url_manager_modal -->
        <div id="myex_url_manager_modal" class="ex_url_manager_modal" style="z-index: 10000">
            <div class="ex_url_manager_modal-content">
                <div class="ex_url_manager_modal-header">
                    <span class="ex_url_manager_btn_close">&times;</span>
                    <h4>Url Picker</h4>
                </div>
                <div class="ex_url_manager_modal-body">
                    <div class="ex_url_manager_tab">
                        <button class="ex_url_manager_tablinks" onclick="exUrlPickerShowTab(event, 'ex_up_search')"><i style="color: gray" class="fa fa-search" aria-hidden="true"></i> Search</button>
                        <button class="ex_url_manager_tablinks" onclick="exUrlPickerShowTab(event, 'ex_up_add_url')"><i style="color: gray" class="fa fa-link" aria-hidden="true"></i> Add Url</button>
                    </div>
                    <div id="ex_up_search" class="ex_url_manager_tabcontent">  
                        <div class="input-group">
                            <div class="input-group-btn"><button  onclick="document.getElementById('ex_up_search_cloud').value='';exUrlPickerSearchData()" class="{$theme_button_class}default btn-md"><i class="fa fa-file" aria-hidden="true"></i> Fetch All</button></div>
                            <input style='padding:10px;display:block' onkeypress="return exUrlPickerSearchData(event)" id='ex_up_search_cloud' placeholder='Search File'  class='form-control'>
                            <div class="input-group-btn"><button onclick="exUrlPickerSearchData()" class="{$theme_button_class}default"><i class="fa fa-search" aria-hidden="true"></i> Search</button></div>
                        </div>
                        
                        <ul style='margin-top:10px' id='um-search-box' class='um-existing_image_con'>
                            <h3 style="color:silver;padding:50px;" align="center">Input name to search</h3>
                        </ul> 
                    </div>
                    <div id="ex_up_add_url" class="ex_url_manager_tabcontent" style="color:gray">  $addUrlBox </div>
                </div>
                <div class="ex_url_manager_modal-footer" class="row">
                    <input style='padding:20px;display:block;width: 100%;margin:5px;' id='ex_url_manager_selected_path' placeholder='Selected file Url http://...'  class='form-control'>
                    <div style="text-align: right">
                        <button class="{$theme_button_class}default" style="margin:5px 0;" onclick="document.getElementById('myex_url_manager_modal').style.display = 'none'"><i class="fa fa-times" aria-hidden="true"></i> Cancel</button>
                        <button class="{$theme_button_class}success" style="margin:5px 0;" onclick="Popup1.confirmLink('Leave Page?', 'Redirect Required', document.getElementById('ex_url_manager_selected_path').value, )"><i class="fa fa-download" aria-hidden="true"></i> Download</button>
                        <button class="{$theme_button_class}primary" style="margin:5px 0;" onclick="exUrlPickerSelectItem();"><i class="fa fa-chevron-right" aria-hidden="true"></i> Select Item</button>
                    </div>
                    <div style="clear: both"></div>
                </div>
            </div>
        </div>
    
        
        
        <!-- Other Style-->
        $style
        <style>
            .um-existing_image_con { max-height:600px; overflow-y: scroll}
            .um-existing_image_delete { float:right; position: relative; background: #de543e;  width:30px;height:30px; text-align: center; border: 2px solid whitesmoke; color:white; border-radius: 40px;margin-left:-50px;margin-top:-15px;font-size:18px;font-weight: 800; cursor: pointer}
            .um-existing_image_item { list-style: none; float: left; margin:10px; padding:5px; background: #898784; color:white; border: 2px solid gray; border-radius: 20px;}
            .um-existing_image_item:active {  background: #346582;  }
            .um-existing_image_item img{ width:100px; height:100px; border-radius: 20px;}
            .um-existing_image_name{ display:block; opacity: 0.6; overflow: hidden; width: 100px; height:20px; text-align: center}
        </style>
       
       
       
        <script>
            // Current InputBox
            var current_input_id, current_file_preview_id, current_obj_container = null;
            /**
            * Assign To any button that should show popup
            *  Like this document.getElementById('$-clickButtonId').onclick = function(){ exumButtonOnClick('$-inputId', '$-filePreviewId') };
            */
            function exumButtonOnClick(_current_input_id, _current_file_preview_id, _current_obj_container){
                current_input_id = _current_input_id;  
                current_file_preview_id = _current_file_preview_id;  
                current_obj_container = _current_obj_container;
                ex_url_manager_modal.style.display = 'block'; 
            }
           
        
            
            
            // Modal 
            let ex_url_manager_modal = document.getElementById('myex_url_manager_modal');
            //document.getElementById("$ clickButtonId").onclick = function () {  ex_url_manager_modal.style.display = "block"; };
            document.getElementsByClassName("ex_url_manager_btn_close")[0].onclick = function(){ ex_url_manager_modal.style.display = "none"; };
            // When the user clicks anywhere outside of the ex_url_manager_modal, close it
            window.onclick = function(event) { if (event.target === ex_url_manager_modal) { ex_url_manager_modal.style.display = "none"; } };
            // show
            //ex_url_manager_modal.style.display = "block";
            
            
            // Tab
            function exUrlPickerShowTab(b,d){var c,e,a;e=document.getElementsByClassName("ex_url_manager_tabcontent");for(c=0;c<e.length;c++){e[c].style.display="none"}a=document.getElementsByClassName("ex_url_manager_tablinks");for(c=0;c<a.length;c++){a[c].className=a[c].className.replace(" active","")}document.getElementById(d).style.display="block";b.currentTarget.className+=" active"};
           
            // show first tab default
            document.getElementsByClassName("ex_url_manager_tablinks")[0].click();
     
           
            function exUrlPickerSearchData(event){
                if(event && event.keyCode !== 13) return;
                 /**
                * Search File
                */
                let search_cloud_con = $('#um-search-box');
                let searcher_textbox = $('#ex_up_search_cloud');
                // searcher_textbox.on('keyup', function(obj){
                    //dd('daf');
                   //setTimeout(function(){
                       search_cloud_con.html('<div style="padding:100px; text-align: center" > $loading <h3 style="color:silver">Searching for [' + searcher_textbox.val() + ']</h3> </div>'); //+  container.html()
                       Ajax1.requestGet("$file_search_controller&q=" + searcher_textbox.val(), '', function(data){
                         if(!data.status) return search_cloud_con.html('<h3 style="color:silver"> <i class="fa fa-folder-open" aria-hidden="true"></i> Result Empty! </h3>');
                         data = data.data;
                         let html_buffer = '';
                         // for(let i in data)  html_buffer +=  "<li  ondblclick='exUrlPickerSelectItem()' onClick='exUrlPickerPastePathUrl(`" + data[i].file_url + "`)' class='btn3d um-existing_image_item' title='" + data[i].file_name + "'><div onclick='exUrlPickerDeleteFile(`" + data[i].file_name + "`, `" + data[i].file_url +  "`, this)' class='um-existing_image_delete'>×</div><img src='" + data[i].file_url + "'><span class='um-existing_image_name'>" + data[i].file_name + "</span></li>";
                        
                         for(let i in data){
                             html_buffer +=  "<li ondblclick='exUrlPickerSelectItem()' onClick='exUrlPickerPastePathUrl(`" + data[i] + "`)' class='btn3d um-existing_image_item' title='" + data[i] + "'><img src='" + Url1.getFileImagePreview(data[i],  '$defaultImage')  + "'><span class='um-existing_image_name'>" + FileManager1.getFileName(data[i]) + "</span></li>";
                         }
                         
                         if(html_buffer === '') search_cloud_con.html('<h3 style="color:silver">No File Found</h3>');
                         else {
                             search_cloud_con.html( html_buffer);
                         }
                      });
                  // }, 500);
                //});
            }
            
        
            
            /**
            * Paste text
            */
            function exUrlPickerPastePathUrl(path){  $('#ex_url_manager_selected_path').val(path); }
            
            
             /**
            * Use Selected Item
            */
            function exUrlPickerSelectItem(){
                let content = document.getElementById('ex_url_manager_selected_path').value;
                if(content.trim() === '') return Popup1.alert('Failed', 'Empty Url', 'error');
                document.getElementById('myex_url_manager_modal').style.display = 'none';
                
                // if(parent control set) ignore the reset
                try{  if(current_obj_container){ current_obj_container.querySelector('textarea').value = (content); current_obj_container.querySelector('img').src = Url1.getFileImagePreview(content,  '$defaultSuccessImage'); return ''; }   }catch (e) {  }
                try{  if(current_input_id) document.getElementById(current_input_id).value =  content; }catch (e) {  }
                try{  if(current_file_preview_id) document.getElementById(current_file_preview_id).src =  Url1.getFileImagePreview(content,  '$defaultSuccessImage'); }catch (e) {  }
                try{  if(current_input_id) document.getElementById(current_input_id).innerHTML =  content; }catch (e) {  }
            }
            
            function exUrlPickerDownloadSelectItem(){
                dd('download...');
            }
            
            
            /**
            * Save new Url
            */
            function exUrlPickerSaveNewUrl(){
                let url = document.getElementById('ex_up_new_url').value;
                let url_name = document.getElementById('ex_up_new_url_name').value;
                if(url.trim() === '') return Popup1.alert('Failed', 'No Url to Add', 'error');
                Popup1.showLoading('Saving...');
                Ajax1.request("$save_url_controller", {file_url:url, file_name:url_name}, function(data){
                    if(data.status) {
                        Popup1.alert('Saved', 'File was Saved as ' + url, 'success');
                        exUrlPickerPastePathUrl(url);
                        document.getElementById('ex_up_new_url').value = '';
                        document.getElementById('ex_up_new_url_name').value = '';
                    }
                    else Popup1.alert('Failed to Save', '', 'error');
                });
            }
        </script>
HTML;
         return $this;
    }


}
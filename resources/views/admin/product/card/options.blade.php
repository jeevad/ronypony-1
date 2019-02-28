<?php $GLOBALS['option_value_count'] = 0;
$count =0;
?>
<style type="text/css">
    .option-form {
        display:none;
        margin-top:10px;
    }
    .option-values-form
    {
        background-color:#fff;
        padding:6px 3px 6px 6px;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        border-radius: 3px;
        margin-bottom:5px;
        border:1px solid #ddd;
    }
    
    .option-values-form input {
        margin:0px;
    }
    .option-values-form a {
        margin-top:3px;
    }
</style>
 <div class="row">
        <div class="span8">
            <div class="pull-right" style="padding:0px 0px 10px 0px;">
                <select id="option_options" style="margin:0px;">
                    <option value="">Selec Option Type</option>
                    <option value="checklist">Checklist</option>
                    <option value="radiolist">Radiolist</option>
                    <option value="droplist">Droplist</option>
                    <option value="textfield">Textfield</option>
                    <option value="textarea">Textarea</option>
                </select>
                <input id="add_option" class="btn" type="button" value="Add Option" style="margin:0px;"/>
            </div>
        </div>
    </div>
    @section('script')
<script type="text/javascript">
    <script type="text/javascript">
    
        $( "#add_option" ).click(function(){
            if($('#option_options').val() != '')
            {
                add_option($('#option_options').val());
                $('#option_options').val('');
            }
        });
        
        function add_option(type)
        {
            //increase option_count by 1
            option_count++;
            
            <?php
            $value			= array(array('name'=>'', 'value'=>'', 'weight'=>'', 'price'=>'', 'limit'=>''));
            $js_textfield	= (object)array('name'=>'', 'type'=>'textfield', 'required'=>false, 'values'=>$value);
            $js_textarea	= (object)array('name'=>'', 'type'=>'textarea', 'required'=>false, 'values'=>$value);
            $js_radiolist	= (object)array('name'=>'', 'type'=>'radiolist', 'required'=>false, 'values'=>$value);
            $js_checklist	= (object)array('name'=>'', 'type'=>'checklist', 'required'=>false, 'values'=>$value);
            $js_droplist	= (object)array('name'=>'', 'type'=>'droplist', 'required'=>false, 'values'=>$value);
            ?>
            if(type == 'textfield')
            {
                $('#options_container').append('<?php //add_option($js_textfield, "'+option_count+'");?>');
            }
            else if(type == 'textarea')
            {
                $('#options_container').append('<?php //add_option($js_textarea, "'+option_count+'");?>');
            }
            else if(type == 'radiolist')
            {
                $('#options_container').append('<?php //add_option($js_radiolist, "'+option_count+'");?>');
            }
            else if(type == 'checklist')
            {
                $('#options_container').append('<?php //add_option($js_checklist, "'+option_count+'");?>');
            }
            else if(type == 'droplist')
            {
                $('#options_container').append('<?php //add_option($js_droplist, "'+option_count+'");?>');
            }
        }
        
        function add_option_value(option)
        {
            
            option_value_count++;
            <?php
            $js_po	= (object)array('type'=>'radiolist');
            $value	= (object)array('name'=>'', 'value'=>'', 'weight'=>'', 'price'=>'');
            ?>
            $('#option-items-'+option).append('<?php //add_option_value($js_po, "'+option+'", "'+option_value_count+'", $value);?>');
        }
        
        $(document).ready(function(){
            $('body').on('click', '.option_title', function(){
                $($(this).attr('href')).slideToggle();
                return false;
            });
            
            $('body').on('click', '.delete-option-value', function(){
                if(confirm('confirm_remove_value'))
                {
                    $(this).closest('.option-values-form').remove();
                }
            });
            
            
            
            $('#options_container').sortable({
                axis: "y",
                items:'tr',
                handle:'.handle',
                forceHelperSize: true,
                forcePlaceholderSize: true
            });
            
            $('.option-items').sortable({
                axis: "y",
                handle:'.handle',
                forceHelperSize: true,
                forcePlaceholderSize: true
            });
        });
        </script>
</script>
@endsection
    
    
    <div class="row">
        <div class="span8">
            <table class="table table-striped"  id="options_container">
                <tr id="option-<?php echo $count;?>">
                    <td>
                        <a class="handle btn btn-mini"><i class="icon-align-justify"></i></a>
                        <strong><a class="option_title" href="#option-form-<?php echo $count;?>"><?php //echo $po->type;?> <?php //echo (!empty($po->name))?' : '.$po->name:'';?></a></strong>
                        <button type="button" class="btn btn-mini btn-danger pull-right" onclick="remove_option(<?php echo $count ?>);"><i class="icon-trash icon-white"></i></button>
                        <input type="hidden" name="option[<?php echo $count;?>][type]" value="<?php //echo $po->type;?>" />
                        <div class="option-form" id="option-form-<?php echo $count;?>">
                            <div class="row-fluid">
                            
                                <div class="span10">
                                    <input type="text" class="span10" placeholder="option_name" name="option[<?php echo $count;?>][name]" value="<?php //echo $po->name;?>"/>
                                </div>
                                
                                <div class="span2" style="text-align:right;">
                                    <input class="checkbox" type="checkbox" name="option[<?php echo $count;?>][required]" value="1" <?php //echo ($po->required)?'checked="checked"':'';?>/> required
                                </div>
                            </div>
                            <?php //if($po->type!='textarea' && $po->type!='textfield'):?>
                            <div class="row-fluid">
                                <div class="span12">
                                    <a class="btn" onclick="add_option_value(<?php echo $count;?>);">add_item</a>
                                </div>
                            </div>
                            <?php //endif;?>
                            <div style="margin-top:10px;">
            
                                <div class="row-fluid">
                                    <?php //if($po->type!='textarea' && $po->type!='textfield'):?>
                                    <div class="span1">&nbsp;</div>
                                    <?php //endif;?>
                                    <div class="span3"><strong>&nbsp;&nbsp;name</strong></div>
                                    <div class="span2"><strong>&nbsp;value</strong></div>
                                    <div class="span2"><strong>&nbsp;weight</strong></div>
                                    <div class="span2"><strong>&nbsp;price</strong></div>
                                    <div class="span2"><strong>&nbsp;<?php //echo ($po->type=='textfield')? 'limit':'';?></strong></div>
                                </div>
                                <div class="option-items" id="option-items-<?php echo $count;?>">
                                {{--  option value  --}}
                                <div class="option-values-form">
                                    <div class="row-fluid">
                                        <?php //if($po->type!='textarea' && $po->type!='textfield'):?><div class="span1"><a class="handle btn btn-mini" style="float:left;"><i class="icon-align-justify"></i></a></div><?php //endif;?>
                                        <div class="span3"><input type="text" class="span12" name="option[<?php echo $count;?>][values][<?php //echo $valcount ?>][name]" value="<?php //echo $value->name ?>" /></div>
                                        <div class="span2"><input type="text" class="span12" name="option[<?php echo $count;?>][values][<?php //echo $valcount ?>][value]" value="<?php //echo $value->value ?>" /></div>
                                        <div class="span2"><input type="text" class="span12" name="option[<?php echo $count;?>][values][<?php //echo $valcount ?>][weight]" value="<?php //echo $value->weight ?>" /></div>
                                        <div class="span2"><input type="text" class="span12" name="option[<?php echo $count;?>][values][<?php //echo $valcount ?>][price]" value="<?php //echo $value->price ?>" /></div>
                                        <div class="span2">
                                        <?php //if($po->type=='textfield'):?>
                                        {{--  <input class="span12" type="text" name="option[<?php echo $count;?>][values][<?php //echo $valcount ?>][limit]" value="<?php //echo $value->limit ?>" />  --}}
                                        <?php //elseif($po->type!='textarea' && $po->type!='textfield'):?>
                                            <a class="delete-option-value btn btn-danger btn-mini pull-right"><i class="icon-trash icon-white"></i></a>
                                        <?php //endif;?>
                                        </div>
                                    </div>
                                </div>
                                    {{--  option value end  --}}
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                    
            </table>
        </div>
    </div>
<?php
   
    
    function add_option_value($po, $count, $valcount, $value)
    {
        ob_start();
        ?>
        
        <?php
        $stuff = ob_get_contents();
    
        ob_end_clean();
    
        echo replace_newline($stuff);
    }
    //this makes it easy to use the same code for initial generation of the form as well as javascript additions
    function replace_newline($string) {
      return trim((string)str_replace(array("\r", "\r\n", "\n", "\t"), ' ', $string));
    } ?>
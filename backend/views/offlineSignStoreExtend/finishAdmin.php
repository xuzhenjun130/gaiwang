<?php
/* @var $this OfflineSignStoreController */
/* @var $model OfflineSignStore */
$this->breadcrumbs = array('电子化签约审核列表' => array('offlineSignStoreExtend/admin'), '审核完毕列表');

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#offline-sign-store-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<script type="text/javascript" language="javascript" src="js/iframeTools.source.js"></script>
<?php $this->renderPartial('_adminTop'); ?>
<br/>
<?php  $this->renderPartial('_search', array('model' => $model,'role'=>$this->role)); ?>

<?php
$this->widget('GridView',array(
    'id'=>'offline-sign-store-extend-grid',
    'dataProvider' => $model->searchManage($this->role),
    'itemsCssClass' => 'tab-reg',
    'afterAjaxUpdate' => 'function() { col_add(); }',
    'template' => '{items}{pager}',
    'columns' => array(
        array(
            'htmlOptions' => array('class' => 'tc'),
            'headerHtmlOptions' => array('class' => 'tabletd tc','width' => '10%px'),
            'name' => 'update_time',
            'value' => 'date("Y-m-d H:i:s",$data->update_time)',
        ),
        array(
            'htmlOptions' => array('class' => 'tc'),
            'headerHtmlOptions' => array('class' => 'tabletd tc','width' => '10%px'),
            'name' => 'create_time',
            'value' => 'date("Y-m-d H:i:s",$data->create_time)',
        ),
        array(
            'htmlOptions' => array('class' => 'tc'),
            'headerHtmlOptions' => array('class' => 'tabletd tc','width' => '15%px'),
            'name' => 'enTerName',
            'value' => '$data->enTerName',
        ),
        array(
            'htmlOptions' => array('class' => 'tc'),
            'headerHtmlOptions' => array('class' => 'tabletd tc','width' => '12%px'),
            'value' => 'OfflineSignStoreExtend::getApplyType($data->apply_type)',
        ),
        array(
            'htmlOptions' => array('class' => 'tc'),
            'headerHtmlOptions' => array('class' => 'tabletd tc','width' => '9%px'),
            'name'=>'audit_status',
            'value' => 'OfflineSignStoreExtend::getAuditStatusEx($data->role,$data->audit_status,$data->status)',
        ),
        array(
            'htmlOptions' => array('class' => 'tc'),
            'headerHtmlOptions' => array('class' => 'tabletd tc','width' => '10%px'),
            'name' => 'repeat_audit',
            'value' => 'OfflineSignStoreExtend::getIsRepeatAudit($data->repeat_audit)',
        ),
        array(
            'htmlOptions' => array('class' => 'tc'),
            'headerHtmlOptions' => array('class' => 'tabletd tc','width' => '8%px'),
            'name' => 'is_import',
            'value' => 'OfflineSignStoreExtend::getIsImport($data->is_import)',
        ),
        array(
            'htmlOptions' => array('class' => 'tc'),
            'headerHtmlOptions' => array('class' => 'tabletd tc','width' => '10%px'),
            'name' => 'repeat_application',
            'value' => 'OfflineSignStoreExtend::getISRepeatApplication($data->repeat_application)',
        ),
        array(
            'htmlOptions' => array('class' => 'tc'),
            'headerHtmlOptions' => array('class' => 'tabletd tc','width' => '10%px'),
            'name' => 'agent_id',
            'value' => 'OfflineSignStore::getEnterpriseName($data->agent_id)',
        ),
        array(
            'htmlOptions' => array('class' => 'tc'),
            'headerHtmlOptions' => array('class' => 'tabletd tc','width' => '15%px'),
            'name' => '操作',
            'type' => 'raw',
            'value' => 'OfflineSignStoreExtend::createButtonsOther($data->primaryKey)',
        ),
    )
));
?>
<div style="display: none;" id="confirmArea">
    <style>
        .aui_buttons{
            text-align: center;
        }
        .buttonOff{
            width: 55px;
        }
    </style>
    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="tab-come">
        <tbody>
        <tr class="confirmTR" style="background:#FFF;">
            <td>
                <textarea id="remark" cols="50" rows="5" onfocus="if(value=='请输入备注内容'){value=''}" onblur="if (value ==''){value='请输入备注内容'}">请输入备注内容</textarea>
            </td>
        </tr>
        </tbody>
    </table>
</div>
<script type="text/javascript">
    function addRemark(id,role){
        art.dialog({
            title: '<?php echo '添加备注内容' ?>',
            okVal: '<?php echo '确定' ?>',
            cancelVal: '<?php echo '取消' ?>',
            content: $("#confirmArea").html(),
            lock: true,
            cancel: true,
            ok: function () {
                //数据检验
                var remarkContent = $('#remark').val();
                if (remarkContent == '请输入备注内容' || remarkContent.length > 200) {
                    art.dialog({
                        icon: 'warning',
                        content: '请注意备注内容不能为空或长度不能超过200',
                        lock: true,
                        ok: function () {
                            $('#remark').focus();
                        }
                    });
                    return false;
                }
                //发送ajax验证
                var url = '<?php echo $this->createAbsoluteUrl('/offlineSignStore/addRemarks') ?>';
                $.ajax({
                    type: "post", async: false, dataType: "json", timeout: 5000,
                    url: url,
                    data:{YII_CSRF_TOKEN: '<?php echo Yii::app()->request->csrfToken ?>',id:id,role:role,remark:remarkContent},
                    success:function(data){
                        if(data.success)
                            art.dialog({icon: 'success', content: data.success, ok:true});
                        else
                            art.dialog({icon: 'warning', content: data.error, ok:true});
                    }
                });

            }
        })
    }

    col_add();
    /*动态添加状态和流程下拉框*/
    function col_add() {
        var selObj = $("#offline-sign-store-extend-grid_c3");
        selObj.append("<select onchange='changeStatus();'><option value=''>"+'新增类型'+"</option><option value=<?php echo OfflineSignStoreExtend::APPLY_TYPE_NEW_FRANCHIESE?>>"+'新商户'+"</option><option value=<?php echo OfflineSignStoreExtend::APPLY_TYPE_OLD_FRANCHIESE?>>"+'原有会员新增加盟商'+"</option></select>");


        $("#offline-sign-store-extend-grid_c3  option[value=<?php echo !empty($model->apply_type)?($model->apply_type):'';?>] ").attr("selected",true);

        $('#apply_type').val(<?php echo !empty($model->apply_type)?($model->apply_type):'';?>);
    }

    /**按状态条件来查询记录*/
    function changeType(){
        var apply_type = $("#offline-sign-store-extend-grid_c3").find("option:selected").val();
        window.location.href = "<?php echo Yii::app()->createUrl('/OfflineSignStoreExtend/admin');?>&role=<?php echo $this->role;?>&apply_type="+apply_type;
    }
    function changeStatus(){
        var hideDiv = $('#yw0').find('div:first');
        hideDiv.find('input:first').val('offline-sign-store-extend/finishAdmin')

        var apply_type = $("#offline-sign-store-extend-grid_c3").find("option:selected").val();

        $('#apply_type').val(apply_type);
        $('#yw0').submit();
    }
</script>
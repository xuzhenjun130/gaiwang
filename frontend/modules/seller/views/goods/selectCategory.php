<?php
/** @var GoodsController $this */
/** @var $store Store */
$this->breadcrumbs=array(
    Yii::t('sellerGoods','宝贝管理')=>array('index'),
    Yii::t('sellerGoods','我要卖'),
);
?>
<link href="<?php echo CSS_DOMAIN; ?>custom.css" rel="stylesheet" type="text/css" />
<div class="toolbar">
    <b><?php echo Yii::t('sellerGoods','我要卖'); ?></b>
    <span><?php echo Yii::t('sellerGoods','添加新的宝贝信息资料。'); ?></span>
</div>
<div class="proAddStep">
    <ul class="s1">
        <li><?php echo Yii::t('sellerGoods','选择商品所在分类'); ?></li>
        <li><?php echo Yii::t('sellerGoods','填写商品详细信息'); ?></li>
        <li><?php echo Yii::t('sellerGoods','商品发布成功'); ?></li>
    </ul>
</div>
<div class="proAddStepOne">
     <div id="dataLoading" class="wp_data_loading">
      <div class="data_loading"><?php echo Yii::t('sellerGoods','加载中...'); ?></div>
    </div>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="sellerT1">
        <tr><td colspan="4" class="td_title"><?php echo Yii::t('sellerGoods','选择商品所在分类'); ?></td></tr>
        <tr>
            <th width="10%"><?php echo Yii::t('sellerGoods','当前选的分类'); ?></th>
            <td width="40%"></td>
            <th width="10%"><?php echo Yii::t('sellerGoods','您常用的分类'); ?></th>
            <td width="40%">
            </td>
        </tr>
        <tr>
            <th><?php echo Yii::t('sellerGoods','商品类别'); ?></th>
            <td style="padding:0;">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="sellerT2">
                    <tr>
                        <td width="33%">
                            <div class="wp_category_list">
                                <div id="class_div_1" class="category_list">
                                    <ul class="category">
                                        <?php 
                                            $topCate=  Category::getTop($store->category_id);
                                            foreach ($topCate as $v):
                                                if($v->status==Category::STATUS_DISABLE) continue;
                                        ?>
                                        <li id="<?php echo $v->id.'|'.$v->type_id?>" onclick="selectClass(this);">
                                            <?php echo CHtml::link(Yii::t('category', $v->name),'javascript:void(0)',
                                                array('data-id'=>$v->id,'class'=>'')) ?>
                                        </li>
                                        <?php endforeach; ?>
                                       
                                    </ul>
                                </div>
                            </div>
                        </td>
                        
                        <td width="33%">
                            <div class="wp_category_list blank">
                                <div id="class_div_2" class="category_list">
                                    <ul class="category">
                                    </ul>
                                </div>
                            </div>
                           
                        </td>
                        <td width="34%">

                            <div class="wp_category_list blank">
                                <div id="class_div_3" class="category_list">
                                    <ul class="category">
                                    </ul>
                                </div>
                            </div>

                        </td>
                    </tr>
                </table>
            </td>
            <td colspan="2" style="padding: 10px; vertical-align: top" id="categoryStaple">
                <ul>
            <?php if($categoryStaple): ?>
                    <li></li>
                <?php foreach($categoryStaple as $v): ?>
                    <li data-id="<?php echo $v['id'] ?>">
                    <?php
                    echo CHtml::link($v['name'],'#',array('class'=>'selectStaple','data-cid'=>$v['category_id'],'style'=>'color:#3366cc')).' --- ';
                    echo CHtml::link(Yii::t('sellerGoods','删除'),'#',array('class'=>'delStaple'))
                    ?>
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>
                </ul>
            </td>
        </tr>
    </table>
    
    <div class="tips_choice"  style="display: block; clear:both;"><span class="tips_zt"></span>
        <dl class="hover_tips_cont">
            <dt id="commodityspan"><span style="color:#F00;"><?php echo Yii::t('sellerGoods','请选择商品类别'); ?></span></dt>
            <dt id="commoditydt" style="display: none;" class="current_sort"><?php echo Yii::t('sellerGoods','您当前选择的商品类别是：'); ?></dt>
            <dd id="commoditydd"></dd>
            <dd id="commoditya" style="display: none" >&nbsp;&nbsp;<a href="JavaScript:void(0);">[<?php echo Yii::t('sellerGoods','添加到常用分类') ?>]</a></dd>
        </dl>
    </div>
    
    <div class="next">
        <form method="get">
            <input name="id" type="hidden" value="<?php echo $this->getParam('id') ?>" >
            <input name="class_id" id="class_id" value="" type="hidden" />
            <input name="t_id" id="t_id" value="" type="hidden" />
            <input disabled="disabled" id="button_next_step" class="sellerBtn06" value="<?php echo Yii::t('sellerGoods','下一步'); ?>" type="submit"   />
            <?php if($this->getParam('id')): ?>
                <a onclick="history.back()">[<?php echo Yii::t('sellerGoods','返回'); ?>]</a>
            <?php endif; ?>
        </form>
       
    </div>
</div>
<script>
    //动态的js数据
    var commonData = {
        getJsonUrl:"<?php echo $this->createAbsoluteUrl('goods/getJson') ?>",
        addCategoryStapleUrl:"<?php echo $this->createAbsoluteUrl('goods/addCategoryStaple') ?>",
        delStapleUrl:"<?php echo $this->createAbsoluteUrl('goods/delStaple') ?>",
        delText:"<?php echo Yii::t('sellerGoods','删除') ?>",
        selectStapleUrl:"<?php echo $this->createAbsoluteUrl('goods/selectStaple') ?>"
    };
</script>
<script type="text/javascript" src="<?php echo DOMAIN; ?>/js/jquery.goods_add_step1.js"></script>
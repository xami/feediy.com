<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">

	<div id="header">
		<div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
	</div><!-- header -->

	<div id="mainmenu">
		<?php $this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				array('label'=>'首页', 'url'=>'/'),
				array('label'=>'网站地图生成工具', 'url'=>array('/site/page', 'view'=>'about')),
				array('label'=>'联系', 'url'=>array('/site/contact')),
//				array('label'=>'登陆', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
//				array('label'=>'退出 ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
			),
		)); ?>
	</div><!-- mainmenu -->
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> By <a href="http://www.feediy.com">www.feediy.com</a>&nbsp;&nbsp;<a href="http://sitemap.feediy.com">sitemap.feediy.com(网站支持列表)</a><br />
        友情链接:&nbsp;&nbsp;
        <a href="http://www.orzero.com">或零</a>&nbsp;-&nbsp;
        <a href="http://www.orzero.net">或零日志</a>&nbsp;-&nbsp;
        <a href="http://www.xxer.info">新客</a>&nbsp;-&nbsp;
        <a href="http://avup.info">AVUP</a>&nbsp;-&nbsp;
        <a href="http://www.odube.com">odube.com</a>&nbsp;-&nbsp;
        <a href="http://www.haoselang.com">HaoSeLang</a>&nbsp;-&nbsp;
        <a href="http://www.snlg.info">SNLG</a>&nbsp;-&nbsp;
        <a href="http://www.yardown.com">yardown.com</a>&nbsp;-&nbsp;
        <a href="http://www.mtianya.com">M天涯</a>&nbsp;-&nbsp;
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
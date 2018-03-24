<?php
namespace frontend\widgets\post;

use Yii;
use yii\base\Widgets;

class PostWidget extends Widget
{
	
	public function run()
	{
		return $this->render('index');
	}
}
<?php 

class Alert extends CWidget
{
	public $page;

	public function init()
	{
		$url = explode('?', $_SERVER['REQUEST_URI']);
		$this->page = $url[0];
	}

	public function get()
	{
		$result = false;

		$alerts = Yii::app()->db->createCommand('SELECT * FROM alerts WHERE active = 1')->queryAll();

		foreach ($alerts as $alert) 
		{
			$pages = explode("\n", $alert['pages']);

			if ($alert['show'] == 0 && in_array($this->page, $pages)) {
				$result = $alert;
				break;
			} else if ($alert['show'] == 1 && !in_array($this->page, $pages)) {
				$result = $alert;
				break;
			}
		}

		//var_dump($result); die();

		if ($result && !empty($result['template'])) {
			return $this->render('alert_' . $result['template'], array(
				'result' => $result
			));
		}		
	}
}
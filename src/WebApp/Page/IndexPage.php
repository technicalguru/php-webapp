<?php

namespace WebApp\Page;

use WebApp\Component\Paragraph;
use WebApp\Component\Table;

class IndexPage extends \WebApp\Page {

	public function __construct($app) {
		parent::__construct($app);
	}

	public function getTitle() {
		return 'Hello World!';
	}

	public function getMain() {
		$rc = array();
		$rc[] = new Paragraph($this, '<b>Congratulations!</b> This is the default page from the web framework.');
		$table = new Table($this);
		$rc[] = $table;
		$table->setStyle('margin-left', '10px');
		$this->addRow($table, 'Vault',            $this->app->vault != NULL ? 'Configured' : 'Not Configured');
		$this->addRow($table, 'Database',         $this->app->database != NULL ? 'Configured' : 'Not Configured');
		$this->addRow($table, 'Data Model',       $this->app->dataModel != NULL ? 'Configured' : 'Not Configured');
		$this->addRow($table, 'Authentication',   $this->app->authentication != NULL ? 'Configured' : 'Not Configured');
		$this->addRow($table, 'Authorization',    $this->app->authorization != NULL ? 'Configured' : 'Not Configured');
		$this->addRow($table, 'Session Handler',  $this->app->sessionHandler != NULL ? 'Configured' : 'Not Configured');
		$this->addRow($table, 'Email Queue',      $this->app->mailQueue != NULL ? 'Configured' : 'Not Configured');
		$this->addRow($table, 'Language',         \TgI18n\I18N::$defaultLangCode);
		$this->addRow($table, 'Default Timezone', WFW_TIMEZONE);

		return $rc;
	}

	protected function addRow($table, $label, $value) {
		$row  = $table->createRow();
		$row->createCell($label.':', TRUE)->setAttribute('align', 'left');
		$row->createCell($value);
	}
}


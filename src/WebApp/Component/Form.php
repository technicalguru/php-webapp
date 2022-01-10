<?php

namespace WebApp\Component;

/** This class is deprecated. Use 
  * - VerticalForm
  * - HorizontalForm
  * - GridForm
  * - InlineForm
  */
class Form extends AbstractForm {

	public const VERTICAL   = 'vertical';
	public const HORIZONTAL = 'horizontal';
	public const GRID       = 'grid';
	public const INLINE     = 'inline';

	protected $type;

	public function __construct($parent, $id, $type = Form::VERTICAL) {
		parent::__construct($parent, $id);
		\TgLog\Log::warn('\WebApp\Component\Form is deprecated. Use the '.ucfirst($type).'Form instead');
		$this->type = $type;
	}

	public function getType() {
		return $this->type;
	}

}


<?php

namespace App\Components;

use Nette\Application\UI\Form;
use Tomaj\Form\Renderer\BootstrapRenderer;

class ExampleFormWithFactory
{

	/**
	 * @var FormFactory
	 */
	private $formFactory;

	/**
	 * @var callable
	 */
	public $onSuccess;

	/**
	 * @param FormFactory $formFactory
	 */
	public function __construct(FormFactory $formFactory)
	{
		$this->formFactory = $formFactory;
	}

	/**
	 * @return Form
	 */
	public function create()
	{
		$form = $this->formFactory->create();
		$form->addText('test', 'Example 2');
		$form->onSuccess[] = [$this, 'formSuccess'];
		return $form;
	}

	/**
	 * @param Form $form
	 * @param $values
	 */
	private function formSuccess(Form $form, $values)
	{
		$this->onSuccess($values);
	}

}

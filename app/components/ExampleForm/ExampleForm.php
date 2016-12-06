<?php

namespace App\Components;

use Nette\Application\UI\Control;
use Nette\Application\UI\Form;

class ExampleForm extends Control
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
		parent::__construct();
	}

	public function render()
	{
		$this->template->setFile(__DIR__.'/template.latte');
		$this->template->render();
	}

	/**
	 * @return Form
	 */
	public function createComponentForm()
	{
		$form = $this->formFactory->create();
		$form->addText('test', 'Example 1');
		$form->onSuccess = [$this, 'formSuccess'];
		return $form;
	}

	/**
	 * @param Form $form
	 * @param $values
	 */
	public function formSuccess(Form $form, $values)
	{
		$this->onSuccess($values);
	}
}
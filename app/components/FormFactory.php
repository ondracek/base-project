<?php

namespace App\Components;

use Nette\Application\UI\Form;
use Tomaj\Form\Renderer\BootstrapRenderer;
use Kdyby\Translation\Translator;

final class FormFactory
{

	/** @var Translator */
	private $translator;

	/**
	 * @var BootstrapRenderer
	 */
	private $bootstrapRenderer;

	/**
	 * FormFactory constructor.
	 * @param Translator $translator
	 * @param BootstrapRenderer $bootstrapRenderer
	 */
	public function __construct(Translator $translator, BootstrapRenderer $bootstrapRenderer)
	{
		$this->translator = $translator;
		$this->bootstrapRenderer = $bootstrapRenderer;
	}

	/**
	 * @return Form
	 */
	public function create($protection = true)
	{
		$form = new Form;
		if ($protection) {
			$form->addProtection();
		}
		$form->setRenderer($this->bootstrapRenderer);
		$form->setTranslator($this->translator);
		return $form;
	}
}

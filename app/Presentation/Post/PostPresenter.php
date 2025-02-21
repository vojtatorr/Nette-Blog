<?php

declare(strict_types=1);

namespace App\Presentation\Post;

use Nette\Application\UI\Presenter;
use Nette\Database\Explorer;
use Nette\Application\UI\Form;

class PostPresenter extends Presenter
{
    public function __construct(
        private Explorer $db,
    ) { }

    public function renderShow(int $postId): void
	{
		$post = $this->db->table('post')->get($postId);

		if(!$post){
			$this->error('Omlováme se, ale Vámi zvolený příspěvěk neexistuje!!!', 404);
		}
		$this->template->post = $this->db
			->table('post')
			->get($postId);
		$this->template->comments = $post->related('comment')->order("created_at");
		
	}

	protected function createComponentCommentForm(): Form
	{
		$form = new Form();
	
		$form->addText('name', 'Jméno:')
			->setRequired();
	
		$form->addEmail('email', 'E-mail:');
	
		$form->addTextArea('content', 'Komentář:')
			->setRequired();
	
		$form->addSubmit('send', 'Publikovat komentář');

		$form->onSuccess[] = [$this, 'commentFormSucceeded'];
	
		return $form;
	}

	public function commentFormSucceeded(Form $form, \stdClass $values): void
{
	$postId = $this->getParameter('postId');

	$this->db->table('comment')->insert([
		'post_id' => $postId,
		'name' => $values->name,
		'email' => $values->email,
		'content' => $values->content,
	]);

	$this->flashMessage('Děkuji za komentář', 'success');
	$this->redirect('this');
}

protected function createComponentPostForm(): Form
{
	$form = new Form;
	$form->addText('title', 'Titulek:')
		->setRequired();
	$form->addTextArea('content', 'Obsah:')
		->setRequired();

	$form->addSubmit('send', 'Uložit a publikovat');
	$form->onSuccess[] = $this->postFormSucceeded(...);

	return $form;
}

private function postFormSucceeded(Form $form, array $values): void
{
	$postId = $this->getParameter("postId");

	if ($postId) {
		$post = $this->db
			->table('post')
			->get($postId);
		$post->update($values);

	} else {
		$post = $this->db
			->table('post')
			->insert($values);
	}

	$this->flashMessage('Příspěvek byl úspěšně publikován.', 'success');
	$this->redirect('Post:show', $post->id);
}

public function actionEdit(int $postId): void
{
	$post = $this->db
		->table('post')
		->get($postId);

	if (!$post) {
		$this->error('Post not found');
	}

	$this['postForm']->setDefaults($post->toArray());
}
}

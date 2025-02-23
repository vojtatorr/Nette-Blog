<?php

declare(strict_types=1);

namespace App\Presentation\Post;

use Nette\Application\UI\Presenter;
use App\Model\PostManager;
use App\Model\CommentManager;
use Nette\Application\UI\Form;

class PostPresenter extends Presenter
{
    public function __construct(
        private PostManager $postManager,
		private CommentManager $commentManager,
    ) { }
  
	public function actionManipulate(int $postId = 0): void
	{
		$this->canonicalize('Post:manipulate', ['postId' => $postId]);

		if (!$this->getUser()->isLoggedIn()){
			$this->flashMessage("Pro tuto akci je nutné se přihlásit", "error");
			$this->redirect("Sign:in");
		}

		if ($postId == 0){
			return;
		}

		$post = $this->postManager->getById($postId);

		if (!$post) {
			$this->error('Omlouváme se, ale Vámi zvolený příspěvěk neexistuje!!!', 404);
		}

		$this['postForm']->setDefaults($post->toArray());
	}

	public function renderManipulate(int $postId = 0){
		$this->template->postId = $postId;
	}

    public function renderShow(int $postId): void
	{
		$post = $this->postManager->getById($postId);

		if(!$post){
			$this->error('Omlováme se, ale Vámi zvolený příspěvěk neexistuje!!!', 404);
		}

		$this->template->post = $post;
		$this->template->comments = $this->commentManager->getCommentsByPostId($postId);
		
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

		$this->commentManager->insert([
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

	public function postFormSucceeded(Form $form, array $values): void
		{
			if (!$this->getUser()->isLoggedIn()){
				$this->error("Pro vytvoření, nebo aditováání příspěvku se musíte přihlásit.");
			}

			$postId = $this->getParameter("postId");

			if ($postId) {
				$post = $this->postManager->getById($postId);
				$post->update($values);

			} else {
				$post = $this->postManager->insert($values);
			}

			$this->flashMessage('Příspěvek byl úspěšně publikován.', 'success');
			$this->redirect('Post:show', $post->id);
		}

}

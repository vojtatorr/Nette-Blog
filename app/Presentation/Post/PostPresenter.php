<?php

declare(strict_types=1);

namespace App\Presentation\Post;

use Nette\Application\UI\Presenter;
use Nette\Database\Explorer;

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
		
	}

}
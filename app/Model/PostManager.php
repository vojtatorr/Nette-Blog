<?php

declare(strict_types=1);

namespace App\Model;

use Nette\Database\Explorer;
use Nette\Database\Table\Selection;
use Nette\SmartObject;
use Nette\Utils\DateTime;
use Nette\Database\Table\ActiveRow;

class PostManager
{
    use SmartObject;

    public function __construct(
        private Explorer $db,
    ) { }

    public function getAll(): Selection
    {
        return $this->db->table('post');
    }

    public function getById(int $id): ?ActiveRow
{
    return $this->getAll()->get($id);
}

    public function insert(array $values): ActiveRow 
    {
        $retVal = $this->getAll()->insert($values);

        // Mail sent START

        if (Debugger::$productionMode){
            $message = new Message();
            $message->setFrom("JohnDoe@gmail.com");
            $message->addTo("default@news.cz");
    
            $message->setSubject("Byl přidán nový článek.");
            $message->setHtmlBody("<h2>Na Vašem webu byl přidán nový článek.</h2><p>Právě na Vašem webu přibyl nový článek s názvem " . $values["title"] . "</p>");
    
            $sender = new SendmailMailer();
            $sender->send($message);
        }

        //Mail send END


    }

    public function getPublicPosts(int $limit = null): Selection
    {
        $retVal = $this->getAll()
            ->where('created_at < ', new DateTime)
            ->order('created_at DESC');

		if ($limit){
			$retVal->limit($limit);
		}

		return $retVal;
    }
}
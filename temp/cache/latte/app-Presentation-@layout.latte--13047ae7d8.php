<?php

declare(strict_types=1);

use Latte\Runtime as LR;

/** source: C:\xampp\htdocs\nette-blog\app\Presentation/@layout.latte */
final class Template_13047ae7d8 extends Latte\Runtime\Template
{
	public const Source = 'C:\\xampp\\htdocs\\nette-blog\\app\\Presentation/@layout.latte';

	public const Blocks = [
		['scripts' => 'blockScripts'],
	];


	public function main(array $ʟ_args): void
	{
		extract($ʟ_args);
		unset($ʟ_args);

		if ($this->global->snippetDriver?->renderSnippets($this->blocks[self::LayerSnippet], $this->params)) {
			return;
		}

		echo '<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width">

	<title>';
		if ($this->hasBlock('title')) /* line 7 */ {
			$this->renderBlock('title', [], function ($s, $type) {
				$ʟ_fi = new LR\FilterInfo($type);
				return LR\Filters::convertTo($ʟ_fi, 'html', $this->filters->filterContent('stripHtml', $ʟ_fi, $s));
			}) /* line 7 */;
			echo ' | ';
		}
		echo 'Nette Web</title>

	<link rel="stylesheet" href="';
		echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 9 */;
		echo '/css/default.css">
</head>

<body>
';
		foreach ($flashes as $flash) /* line 13 */ {
			echo '	<div';
			echo ($ʟ_tmp = array_filter(['flash', $flash->type])) ? ' class="' . LR\Filters::escapeHtmlAttr(implode(" ", array_unique($ʟ_tmp))) . '"' : "" /* line 13 */;
			echo '>';
			echo LR\Filters::escapeHtmlText($flash->message) /* line 13 */;
			echo '</div>
';

		}

		echo '
	<ul class="navig">
		<li>
			<a href="';
		echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link('Home:')) /* line 17 */;
		echo '">Články</a></li>
';
		if ($user->isLoggedIn()) /* line 18 */ {
			echo '				<li><a href="';
			echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link('Sign:out')) /* line 19 */;
			echo '">Odhlásit</a></li>
';
		} else /* line 20 */ {
			echo '				<li><a href="';
			echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link('Sign:in')) /* line 21 */;
			echo '">Přihlásit</a>
		</li>
';
		}
		echo '	</ul>

';
		$this->renderBlock('content', [], 'html') /* line 26 */;
		echo "\n";
		$this->renderBlock('scripts', get_defined_vars()) /* line 28 */;
		echo '</body>
</html>
';
	}


	public function prepare(): array
	{
		extract($this->params);

		if (!$this->getReferringTemplate() || $this->getReferenceType() === 'extends') {
			foreach (array_intersect_key(['flash' => '13'], $this->params) as $ʟ_v => $ʟ_l) {
				trigger_error("Variable \$$ʟ_v overwritten in foreach on line $ʟ_l");
			}
		}
		return get_defined_vars();
	}


	/** {block scripts} on line 28 */
	public function blockScripts(array $ʟ_args): void
	{
		echo '	<script src="https://unpkg.com/nette-forms@3"></script>
';
	}
}

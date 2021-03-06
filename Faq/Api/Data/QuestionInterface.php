<?php

namespace Codelegacy\Faq\Api\Data;

interface QuestionInterface extends BaseInterface
{
    const KEY_ID = 'question_id';
    const KEY_CATEGORY_ID = 'category_id';
    const KEY_CONTENT = 'content';
    const KEY_USEFUL = 'useful';
    const KEY_USELESS = 'useless';

    /**
     * @return int
     */
    public function getCategoryId(): int;

    /**
     * @param int $categoryId
     *
     * @return void
     */
    public function setCategoryId(int $categoryId);

    /**
     * @return string
     */
    public function getContent(): string;

    /**
     * @param string $content
     *
     * @return void
     */
    public function setContent(string $content);

    /**
     * @return int
     */
    public function getUseful(): int;

    /**
     * @param int $usefulCount
     *
     * @return void
     */
    public function setUseful(int $usefulCount);

    /**
     * @return int
     */
    public function getUseless(): int;

    /**
     * @param int $uselessCount
     *
     * @return void
     */
    public function setUseless(int $uselessCount);
}
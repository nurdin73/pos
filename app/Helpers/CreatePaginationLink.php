<?php
namespace App\Helpers;

class CreatePaginationLink
{
    protected $data;
    protected $links;
    protected $currentPage;

    public function __construct($data, $links, $currentPage) {
        $this->data = $data;
        $this->links = $links;
        $this->currentPage = $currentPage;
    }

    protected function removeEnterTab(String $input)
    {
        return str_replace(array("\n\r", "\n", "\r","  "), '', $input );
    }

    protected function removeHref(String $input)
    {
        return preg_replace('/href=([\'"])(?<href>.+?)\1/i', '', $input ) ;
    }

    public function removeUl(String $input)
    {
        return preg_replace(array('/<ul.*?>/','/<\/ul>/'), '', $input ) ;
    }

    protected function removeUnusedHtml(String $input)
    {
        return $this->removeHref($this->removeEnterTab($input));
    }

    public function crafting()
    {
        return response()->json([
            'data' => $this->data,
            'currentPage' => $this->currentPage,
            'pagination' => $this->removeUnusedHtml($this->links)
        ]);
    }
}
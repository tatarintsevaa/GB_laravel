<?php


namespace App\Service;


class BuildThreeService
{
    public function build(array &$elements, $parentId = null) {

        $branch = array();

        foreach ($elements as &$element) {

            if ($element['parent_id'] == $parentId) {
                $children = $this->build($elements, $element['id']);
                if ($children) {
                    $element['children'] = $children;
                }
                $branch[$element['id']] = $element;
                unset($element);
            }
        }
        return $branch;
    }
}

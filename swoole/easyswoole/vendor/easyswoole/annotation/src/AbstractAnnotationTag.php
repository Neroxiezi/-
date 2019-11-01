<?php


namespace EasySwoole\Annotation;


abstract class AbstractAnnotationTag
{
    abstract public function tagName():string;
    public function aliasMap():array
    {
        return [static::class];
    }
    abstract public function assetValue(?string $raw);
}
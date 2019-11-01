<?php


namespace EasySwoole\Annotation;


class Annotation
{
    protected $parserTagList = [];
    protected $aliasMap = [];
    protected $strictMode = false;

    function __construct(array $parserTagList = [])
    {
        $this->parserTagList = $parserTagList;
    }

    public function strictMode(?bool $strict = null)
    {
        if($strict !== null){
            $this->strictMode = $strict;
        }
        return $this->strictMode;
    }

    function addParserTag(AbstractAnnotationTag $annotationTag):Annotation
    {
        $this->parserTagList[strtolower($annotationTag->tagName())] = $annotationTag;
        foreach ($annotationTag->aliasMap() as $item){
            if(!isset($this->aliasMap[md5($item)])){
                $this->aliasMap[md5(strtolower($item))] = $annotationTag->tagName();
            }else{
                throw new Exception("alias name {$item} for tag:{$annotationTag->tagName()} is duplicate with tag:{$this->aliasMap[md5($item)]}");
            }
        }
        return $this;
    }

    function deleteParserTag(string $tagName):Annotation
    {
        unset($this->parserTagList[$tagName]);
        return $this;
    }

    function getPropertyAnnotation(\ReflectionProperty $property):array
    {
        $doc = $property->getDocComment();
        $doc = $doc ? $doc : '';
        return $this->parser($doc);
    }

    function getClassMethodAnnotation(\ReflectionMethod $method):array
    {
        $doc = $method->getDocComment();
        $doc = $doc ? $doc : '';
        return $this->parser($doc);
    }

    private function parser(string $doc):array
    {
        $result = [];
        $tempList = explode(PHP_EOL,$doc);
        foreach ($tempList as $line){
            $line = trim($line);
            $pos = strpos($line,'@');
            if($pos !== false && $pos <= 3){
                $lineItem = self::parserLine($line);
                if($lineItem){
                    $tagName = '';
                    if(isset($this->parserTagList[strtolower($lineItem->getName())])){
                        $tagName = $lineItem->getName();
                    }else if(isset($this->aliasMap[md5(strtolower($lineItem->getName()))])){
                        $tagName = $this->aliasMap[md5(strtolower($lineItem->getName()))];
                        /*
                         * 矫正最终名字
                         */
                        $lineItem->setName($tagName);
                    }
                    if(isset($this->parserTagList[strtolower($tagName)])){
                        /** @var AbstractAnnotationTag $obj */
                        $obj = clone $this->parserTagList[strtolower($tagName)];
                        $obj->assetValue($lineItem->getValue());
                        $result[$lineItem->getName()][] = $obj ;
                    }else if($this->strictMode){
                        throw new Exception("parser fail because of unregister tag name:{$lineItem->getName()} in strict parser mode");
                    }
                }else if($this->strictMode){
                    throw new Exception("parser fail for data:{$line} in strict parser mode");
                }
            }
        }
        return $result;
    }

    public static function parserLine(string $line):?LineItem
    {
        $pattern = '/@(\\\?[a-zA-Z][0-9a-zA-Z_\\\]*?)\((.*)\)/';
        preg_match($pattern, $line,$match);
        if(is_array($match) && (count($match) == 3)){
            $item = new LineItem();
            $item->setName(trim($match[1]," \t\n\r\0\x0B\\"));
            $item->setValue(trim($match[2]));
            return $item;
        }else{
            return null;
        }
    }
}
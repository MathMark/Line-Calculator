<?php
//$line=$_POST["expression"];
echo $line;
$stack=new Stack();
//$line="9*(3+5)/2";
//$inputline="(-5-1)/2+7";
$inputline="(5+(-7))/2+9^2";

$line=str_replace("(-","(~",$inputline);


$outputLine=array();

$index=0;
try{


for($i=0;$i<strlen($line);$i++)
{

    if(ctype_digit($line{$i})==1){
        $outputLine[$index]=$line{$i};
        $index++;
    }
    elseif($line{$i}=='(')
    {
        $stack->push($line{$i});
    }
    elseif($line{$i}==')')
    {
        while($stack->top()!='(')
        {
          $outputLine[$index]=$stack->pop();
            $index++;
        }
        $stack->pop();
    }
    elseif($stack->IsOperation($line{$i})){
        if($stack->isEmpty()==1)
        {
            $stack->push($line{$i});
        }
        elseif($stack->getPriority($stack->top())<$stack->getPriority($line{$i}))
        {
            $stack->push($line{$i});
        }
        elseif($stack->getPriority($stack->top())>=$stack->getPriority($line{$i}))
        {

           while(($stack->getPriority($stack->top())>=$stack->getPriority($line{$i})))/*||($stack->isEmpty()!=1))*/
            {
                $outputLine[$index]=$stack->pop();
                $index++;
            }

            $stack->push($line{$i});

        }
    }
    else throw new RuntimeException("There is the unknown symbol - ".$line{$i});


}
}
catch (RuntimeException $e)
{
    echo "\n"." Error: ";
    echo $e->getMessage();
    return;
}
if(!$stack->isEmpty())
{
    while($stack->isEmpty()!=1)
    {
        $outputLine[$index]=$stack->pop();
        $index++;
    }
}
//$stack->showStack();
echo "  ";
for($i=0;$i<count($outputLine);$i++)
{
    echo $outputLine[$i];
}

try
{
for($i=0;$i<count($outputLine);$i++)
{
    if(ctype_digit($outputLine[$i]))
    {
        $stack->push($outputLine[$i]);
    }
    else
    {
        switch($outputLine[$i]){
            case '~':
                $stack->push($stack->pop()*-1);
                break;
            case '^':
                $y=$stack->pop();
                $x=$stack->pop();
                $stack->push($x**$y);
                break;
            case '+':
                $y=$stack->pop();
                $x=$stack->pop();
                $stack->push($x+$y);
                break;
            case '-':
                $y=$stack->pop();
                $x=$stack->pop();
                $stack->push($x-$y);
                break;
            case '*':
                $y=$stack->pop();
                $x=$stack->pop();
                $stack->push($x*$y);
                break;
            case '/':
                $y=$stack->pop();
                $x=$stack->pop();
                $stack->push($x/$y);
                break;

        }



    }
}
echo "   ";
$Result=$stack->pop();
}
catch (RuntimeException $e)
{
    echo "\n"." Error: ";
    echo $e->getMessage();
    return;
}
echo $Result;
//$stack->showStack();

//echo IsStackEmpty($stack);
class Stack
{
    protected $stack;
    protected $limit;

    protected $operations;


    public function __construct($limit=15)
    {
        $this->stack=array();
        $this->limit=$limit;
        $this->operations=array('+','-','*','/','^','~');
    }

    public function IsOperation($symbol)
    {
        for($i=0;$i<count($this->operations);$i++)
        {
            if($symbol==$this->operations[$i])
            {
                return true;
            }
        }
        return false;
    }
    public function push($item) {

        if (count($this->stack) < $this->limit) {
            array_unshift($this->stack, $item);

        } else {
            echo count($this->stack);
            echo $this->limit;
          throw new RunTimeException('Stack is full!');
        }

    }

    public function getPriority($symbol)
    {
        switch($symbol){
            case '~':
                return 5;
            case '^':
                return 4;
            case '/':
                goto q;
            q: case '*':
            return 3;
            case '-':
               goto l;
            l:case '+':
                return 2;
            case '(':
                return 1;
            default: return 0;
        }

    }

    public function pop() {
        if ($this->isEmpty()) {
          throw new RunTimeException('Stack is empty!');
      } else {
            return array_shift($this->stack);
        }
    }
    public function top() {
        return current($this->stack);
    }

    public function isEmpty() {
        return empty($this->stack);
    }

    public function showStack()
    {
        for($i=0;$i<count($this->stack);$i++)
        {
            echo $this->stack[$i];
        }
    }


}

function IsStackEmpty($stack){
    if(count($stack)==0){
        return true;
    }
    else return false;
   // $stack=array();
   // echo count($stack);
}

?>

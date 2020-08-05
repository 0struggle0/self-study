<?php

// 当需要用一个参数来控制众多只有 true、false 选项的时候可以考虑用到位运算来实现，可以用来简化参数的传递并且更为灵活。

class LightControl
{
    const TURN_ON_ALL = 0b11111;
    const KITCHEN     = 0b10000; //'厨房灯'
    const SECOND_LIE  = 0b01000; //'次卧灯'
    const DINING_ROOM = 0b00100; //'餐厅灯'
    const LIVING_ROOM = 0b00010; //'客厅灯'
    const MASTER_ROOM = 0b00001; //'主卧灯'

    private $options;

    public function __construct($options = 0)
    {
        $this->options = $options;
        echo '主卧', "\t";
        echo '客厅', "\t";
        echo '餐厅', "\t";
        echo '次卧', "\t";
        echo '厨房', "\t", PHP_EOL;
    }

    public function showOptions()
    {
        echo self::getOption($this->options, self::MASTER_ROOM), "\t";
        echo self::getOption($this->options, self::LIVING_ROOM), "\t";
        echo self::getOption($this->options, self::DINING_ROOM), "\t";
        echo self::getOption($this->options, self::SECOND_LIE), "\t";
        echo self::getOption($this->options, self::KITCHEN);
    }

    //获取指定灯的开关状态
    private static function getOption($options, $option)
    {
        return intval(($options & $option) > 0);
    }

    public function getOptions()
    {
        return $this->options;
    }

    public function setOptions($options)
    {
        $this->options = $options;
    }
}

// 全部关闭
// $lightControl = new LightControl();
// $lightControl->showOptions();

// 全部打开
// $lightControl = new LightControl(LightControl::TURN_ON_ALL);
// $lightControl->showOptions();

// 排除厨房
// $lightControl = new LightControl(LightControl::TURN_ON_ALL ^ LightControl::KITCHEN);
// $lightControl->showOptions();

// 厨房和餐厅
$lightControl = new LightControl(LightControl::KITCHEN | LightControl::DINING_ROOM);
$lightControl->showOptions();
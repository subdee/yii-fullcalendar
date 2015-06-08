<?php

class EFullCalendar extends CWidget
{
    /**
     * @var array FullCalendar's options.
     */
    public $options = array();

    /**
     * @var array HTML options.
     */
    public $htmlOptions = array();

    /**
     * Run the widget.
     */
    public function run()
    {

        $this->registerFiles();

        echo $this->showOutput();
    }


    /**
     * Register assets.
     */
    protected function registerFiles()
    {
        $compsDir = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'bower_components' . DIRECTORY_SEPARATOR;
        $fcAssetsDir = $compsDir . 'fullcalendar' . DIRECTORY_SEPARATOR . 'dist';
        $momAssetsDir = $compsDir . 'moment' . DIRECTORY_SEPARATOR . 'min';

        $fcAssets = Yii::app()->assetManager->publish($fcAssetsDir);
        $momAssets = Yii::app()->assetManager->publish($momAssetsDir);

        $cs = Yii::app()->clientScript;
        $cs->registerCoreScript('jquery');
        $cs->registerCoreScript('jquery.ui');

        $cs->registerScriptFile($momAssets . '/moment-with-locales.min.js');
        $cs->registerScriptFile($fcAssets . '/fullcalendar.min.js');
        $lang = str_replace('_', '-', strtolower(Yii::app()->language));
        if (!file_exists($fcAssets . '/lang/' . $lang . '.js')) {
            $lang = substr(strtolower(Yii::app()->language), 0, 2);
        }
        $cs->registerScriptFile($fcAssets . '/lang/' . $lang . '.js');

        $cs->registerCssFile($fcAssets . '/fullcalendar.min.css');
        $cs->registerCssFile($fcAssets . '/fullcalendar.print.css', 'print');

        $js = '$("#' . $this->id . '").fullCalendar(' . CJavaScript::encode($this->options) . ');';
        $cs->registerScript(__CLASS__ . '#' . $this->id, $js, CClientScript::POS_READY);

    }

    /**
     * Returns the html output.
     *
     * @return string Html output
     */
    protected function showOutput()
    {
        if (!isset($this->htmlOptions['id'])) {
            $this->htmlOptions['id'] = $this->id;
        }

        return CHtml::tag('div', $this->htmlOptions, '');
    }
}

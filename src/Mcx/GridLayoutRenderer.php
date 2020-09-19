<?php

namespace Mcx;

use WhyooOs\Util\UtilAssert;
use WhyooOs\Util\UtilDebug;

/**
 * 09/2020 created
 */
class GridLayoutRenderer
{
    private float $paperHeight;
    private float $paperWidth;
    private float $gridRowGap = 0;
    private float $gridColumnGap = 0;
    private float $cellWidth;
    private float $cellHeight;
    private string $unit = 'pt';
    private float $marginTop = 0;
    private float $marginRight = 0;
    private float $marginBottom = 0;
    private float $marginLeft = 0;

    /**
     * 09/2020 created
     * @param string $unit
     */
    public function setUnit(string $unit)
    {
        $this->unit = $unit;
    }

    /**
     * 09/2020 created
     *
     * @param float $paperWidth
     * @param float $paperHeight
     */
    public function setPaperSize(float $paperWidth, float $paperHeight)
    {
        $this->paperWidth = $paperWidth;
        $this->paperHeight = $paperHeight;
    }

    private function _getAreaLeft($idxCol): float
    {
        return $idxCol * ($this->cellWidth + $this->gridColumnGap) + $this->marginLeft;
    }

    private function _getAreaTop($idxRow): float
    {
        return $idxRow * ($this->cellHeight + $this->gridRowGap) + $this->marginTop;
    }

    private function _getAreaWidth(float $columnSpan): float
    {
        return $this->cellWidth * $columnSpan + $this->gridColumnGap * ($columnSpan - 1);
    }

    private function _getAreaHeight($rowSpan): float
    {
        return $this->cellHeight * $rowSpan + $this->gridRowGap * ($rowSpan - 1);
    }

    public function renderGridLayout($gridLayout, $areaClass = 'grid-area', $idxCssClassPrefix = 'grid-area-')
    {
        $this->cellWidth = ($this->paperWidth - $this->gridColumnGap * ($gridLayout['numGridColumns'] - 1) - $this->marginLeft - $this->marginRight) / $gridLayout['numGridColumns'];
        $this->cellHeight = ($this->paperHeight - $this->gridRowGap * ($gridLayout['numGridRows'] - 1) - $this->marginTop - $this->marginBottom) / $gridLayout['numGridRows'];
        $htmlDivs = [];
        foreach ($gridLayout['gridAreas'] as $idx => $gridArea) {
            $top = $this->_getAreaTop($gridArea['rowStart']) . $this->unit;
            $left = $this->_getAreaLeft($gridArea['columnStart']) . $this->unit;
            $height = $this->_getAreaHeight($gridArea['rowSpan']) . $this->unit;
            $width = $this->_getAreaWidth($gridArea['columnSpan']) . $this->unit;
            $htmlDivs[] = "<div class='$areaClass $idxCssClassPrefix$idx' style='position:fixed; left:$left; top:$top; width:$width; height:$height;'>$idx</div>";
        }

        return implode("\n", $htmlDivs);
    }

    public function setGridGap(float $gridRowGap, float $gridColumnGap)
    {
        $this->gridRowGap = $gridRowGap;
        $this->gridColumnGap = $gridColumnGap;
    }

    public function setMargin(float $top, float $right, float $bottom, float $left)
    {
        $this->marginTop = $top;
        $this->marginRight = $right;
        $this->marginBottom = $bottom;
        $this->marginLeft = $left;
    }
}

<?php

namespace Ballybran\Library;
class SetupXY {


    public function setupXAxis($percent = '', $color = '')
    {
        $this->bool_x_axis_setup = true;
        if ($percent === false) {
            $this->bool_x_axis = false;
        } else {
            $this->bool_x_axis = true;
        }
        if (!empty($color) && $arr = $this->returnColorArray($color)) {
            $this->x_axis_color = imagecolorallocate($this->image, $arr[0], $arr[1], $arr[2]);
        }
        if (is_numeric($percent) && $percent > 0) {
            $percent = $percent / 100;
            $this->x_axis_margin = round($this->height * $percent);
        } else {
            $percent = self::X_AXIS_MARGIN_PERCENT / 100;
            $this->x_axis_margin = round($this->height * $percent);
        }
    }

    public function setupYAxis($percent = '', $color = '')
    {
        $this->bool_y_axis_setup = true;
        if ($percent === false) {
            $this->bool_y_axis = false;
        } else {
            $this->bool_y_axis = true;
        }
        if (!empty($color) && $arr = $this->returnColorArray($color)) {
            $this->y_axis_color = imagecolorallocate($this->image, $arr[0], $arr[1], $arr[2]);
        }
        if (is_numeric($percent) && $percent > 0) {
            $this->y_axis_margin = round($this->width * ($percent / 100));
        } else {
            $percent = self::Y_AXIS_MARGIN_PERCENT / 100;
            $this->y_axis_margin = round($this->width * $percent);
        }
    }

    public function setRange($min, $max)
    {
        //because of deprecated use of this function as($max, $min)
        if ($min > $max) {
            $this->data_range_max = $min;
            $this->data_range_min = $max;
        } else {
            $this->data_range_max = $max;
            $this->data_range_min = $min;
        }
        $this->bool_user_data_range = true;
    }

    protected function returnColorArray($color)
    {
        //check to see if color passed through in form '128,128,128' or hex format
        if (strpos($color,',') !== false) {
            return explode(',', $color);
        } elseif (substr($color, 0, 1) == '#') {
            if (strlen($color) == 7) {
                $hex1 = hexdec(substr($color, 1, 2));
                $hex2 = hexdec(substr($color, 3, 2));
                $hex3 = hexdec(substr($color, 5, 2));
                return array($hex1, $hex2, $hex3);
            } elseif (strlen($color) == 4) {
                $hex1 = hexdec(substr($color, 1, 1) . substr($color, 1, 1));
                $hex2 = hexdec(substr($color, 2, 1) . substr($color, 2, 1));
                $hex3 = hexdec(substr($color, 3, 1) . substr($color, 3, 1));
                return array($hex1, $hex2, $hex3);
            }
        }

        switch (strtolower($color)) {
            //named colors based on W3C's recd html colors
            case 'black':  return array(0,0,0); break;
            case 'silver': return array(192,192,192); break;
            case 'gray':   return array(128,128,128); break;
            case 'white':  return array(255,255,255); break;
            case 'maroon': return array(128,0,0); break;
            case 'red':    return array(255,0,0); break;
            case 'purple': return array(128,0,128); break;
            case 'fuscia': return array(255,0,255); break;
            case 'green':  return array(0,128,0); break;
            case 'lime':   return array(0,255,0); break;
            case 'olive':  return array(128,128,0); break;
            case 'yellow': return array(255,255,0); break;
            case 'navy':   return array(0,0,128); break;
            case 'blue':   return array(0,0,255); break;
            case 'teal':   return array(0,128,128); break;
            case 'aqua':   return array(0,255,255); break;
        }

        $this->error[] = "Color name \"$color\" not recogized.";
        return false;
    }


}
<?php

/**
 * Created by PhpStorm.
 * User: weilun
 * Date: 2015/8/9
 * Time: 0:00
 */
class UDCmdParser extends CmdParser
{
    public function __construct($protocol_data)
    {
        parent::__construct($protocol_data);
        $this->_need_reply = false;
    }

    public function parse()
    {
        $content = $this->_protocol_data->getContent();
        CustomLogger::getLogger()->info("UD Command Parser handler data [" . $content . "]");
        $parts = explode(",", $content);

        try {
            $datetime = $parts[1] . " " . $parts[2];
            if ($parts[3] == "A") { // 如果定位了,分析定位信息
                CustomLogger::getLogger()->info("[$datetime] Location success ");
                $lat = 0;
                $long = 0;

                //分析维度信息,如果是南纬,在数据前添加负号
                if ($parts[5] == "N") {
                    $lat = $parts[4];
                } else if ($parts[5] == "S") {
                    $lat = "-" . $parts[4];
                } else {
                    CustomLogger::getLogger()->error("[" . $datetime . "]" . " Location data error [" . $parts[5] . "] at index 5");
                }

                // 分析经度信息,如果是西经,则在前面添加负号
                if ($parts[7] == "E") {
                    $long = $parts[6];
                } else if ($parts[7] == "W") {
                    $long = "-" . $parts[6];
                } else {
                    CustomLogger::getLogger()->error("[" . $datetime . "]" . " Location data error [" . $parts[7] . "] at index 7");
                }
                CustomLogger::getLogger()->info("[" . $datetime . "]" . " Update location [$lat,$long]");

                $speed = $parts[8];
                $direction = $parts[9];
                $height = $parts[10];
                $num_starts = $parts[11];
                $gsm_info = $parts[12];
                $power = $parts[13];
                $walk_num = $parts[14];
                $rotate_num = $parts[15];
                $device_status = $parts[16];
                $num_bases = $parts[17];
                $connect_base = $parts[18];
                $contry_code = $parts[19];
                $net_code = $parts[20];
                $tmp = $parts[21];
                $humi = $parts[22];
                $bt_status = $parts[23];

                // discard other info

            } else {
                CustomLogger::getLogger()->info("[" . $datetime . "]" . " Location do not update , do not need store");
            }
        } catch (Exception $e) {
            CustomLogger::getLogger()->error($e->getMessage());
        }
    }
}

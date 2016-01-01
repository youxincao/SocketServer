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
        $this->_need_reply  = false;
    }

    public function parse()
    {
        $content = $this->_protocol_data->getContent();
        CustomLogger::getLogger()->info("UD Command Parser handler data [" . $content . "]");
        $parts = explode(",", $content);

        $datetime = $parts[1]." ".$parts[2];
        if ($parts[3] == "A") {
            CustomLogger::getLogger()->info("[$datetime] Location success ");
            $lat = 0;
            $long = 0;

            //Parse the Lat data
            if ($parts[5] == "N") {
                $lat = $parts[4];
            } else if ($parts[5] == "S") {
                $lat = "-" . $parts[4];
            } else {
                CustomLogger::getLogger()->error("[" . $datetime . "]" . " Location data error [" . $parts[5] . "] at index 5");
            }

            // Parse the long data
            if ($parts[7] == "E") {
                $long = $parts[6];
            } else if ($parts[7] == "W") {
                $long = "-".$parts[6];
            } else {
                CustomLogger::getLogger()->error("[" . $datetime . "]" . " Location data error [" . $parts[7] . "] at index 7");
            }
            CustomLogger::getLogger()->info("[" . $datetime . "]" . " Update location [$lat,$long]");
        } else {
            CustomLogger::getLogger()->info("[" . $datetime . "]" . " Location do not update , do not need store");
        }
    }
}

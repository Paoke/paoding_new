<?php

namespace Api\Model;

class SystemFeedbackModel extends BaseModel
{
    public function feedback($data = array())
    {
        $today = strtotime(date("Y-m-d", time()));
        $num = $this->where("msg_time>$today")->count();
        if ($num > 4) {
            $info = -1;
        } else {
            $info = $this->add($data);
            $info = 1;
        }
        return $info;
    }

    public function feedbackList($id = 0)
    {
        $info = $this->where("user_id=$id")->select();
        return $info;
    }
}
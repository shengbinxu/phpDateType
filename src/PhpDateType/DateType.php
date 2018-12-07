<?php
/**
 * Created by PhpStorm.
 * User: xushengbin
 * Date: 2018/12/7
 * Time: 11:48
 */

namespace PhpDataType;

class DateType
{
    const WORK_DAY_TYPE = 1; // 工作日 -- 国家规定需要上班的日期
    const WEEKEND_TYPE = 2; // 周末 -- 不包括本来是周末，但是又是工作日的日期  2倍工资
    const STATUTORY_HOLIDAY_TYPE = 3; // 假期中的法定节假日 3倍工资
    const REST_DAY = 4; // 假期中的调休日 2倍工资

    /**
     * @var integer $date 日期，格式YYMMDD
     */
    public $date;

    /**
     * DateType constructor.
     * @param $date
     * @throws NotSupportDateTypeException
     */
    public function __construct($date)
    {
        $datetime = new \DateTime($date);
        $date = $datetime->format('Ymd');
        if ($date <= 20181007) {
            throw new NotSupportDateTypeException('不支持20181007之前的日期类型判断');
        }
        $this->date = $date;
    }

    /**
     * @return int
     */
    public function getType()
    {
        $baseDir = dirname(__DIR__);
        $config = json_decode(file_get_contents($baseDir . DIRECTORY_SEPARATOR . 'holiday.json'), 1);
        $workDays = $config['work_days'];
        $holidays = $config['holidays'];
        $statutoryHolidays = $config['statutory_holidays'];
        // 节假日
        if (in_array($this->date, $holidays)) {
            if (in_array($this->date, $statutoryHolidays)) {
                return self::STATUTORY_HOLIDAY_TYPE;
            } else {
                return self::REST_DAY;
            }
        } else if (Util::isWeekEnd($this->date) && !in_array($this->date, $workDays)) {
            return self::WEEKEND_TYPE;
        } else {
            return self::WORK_DAY_TYPE;
        }
    }
}
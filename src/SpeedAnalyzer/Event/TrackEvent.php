<?php

namespace A3020\SpeedAnalyzer\Event;

use Symfony\Component\EventDispatcher\GenericEvent as Event;

final class TrackEvent extends Event implements TrackEventInterface
{
    protected $data = [];

    /**
     * Examples:
     * // Without arguments:
     * \Events::dispatch('on_speed_analyzer_track');
     *
     * // Array without indices
     * \Events::dispatch('on_speed_analyzer_track', new TrackEvent(['debugging info]));
     *
     * // Array with indices
     * \Events::dispatch('on_speed_analyzer_track', new TrackEvent(['Area' => 'Main']));
     *
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->setData($data);
    }

    public function getData()
    {
        return $this->data;
    }

    /**
     * Set analysis / debug data to this event.
     *
     * We eventually want to display the data, so we
     * prefer arrays over objects.
     *
     * @param array $data
     */
    public function setData(array $data)
    {
        $json  = json_encode($data);
        if ($json === false) {
            trigger_error(t("Data can't be json encoded"));
            return;
        }

        $data = json_decode($json, true);
        if (JSON_ERROR_NONE !== json_last_error()) {
            trigger_error("Data can't be json decoded");
            return;
        }

        $this->data = $data;
    }
}

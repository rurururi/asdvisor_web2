<?php

namespace App\Filament\Widgets;

use App\Models\Appointment;
use DateInterval;
use DateTime;
use Filament\Actions\Action;
use Filament\Widgets\Widget;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use Saade\FilamentFullCalendar\Actions;

class CalendarWidget extends FullCalendarWidget
{
    // protected static string $view = 'filament.widgets.calendar-widget';

    public function fetchEvents(array $fetchInfo): array
    {
        // You can use $fetchInfo to filter events by date.
        // This method should return an array of event-like objects. See: https://github.com/saade/filament-fullcalendar/blob/3.x/#returning-events
        // You can also return an array of EventData objects. See: https://github.com/saade/filament-fullcalendar/blob/3.x/#the-eventdata-class
        return Appointment::query()
            ->where('status', '=', 'Approved')
            ->where(function($query) {
                if(auth()->user()->account_level == "Parents") {
                    $query->where('parent_id', auth()->user()->id);
                } else if(auth()->user()->account_level == "Doctor") {
                    $query->where('doctor_id', auth()->user()->id);
                } 
            })
            ->get()
            ->map(function(Appointment $appointment) { 
                $dateTime =  new DateTime($appointment->appointment_date);
                $start = $dateTime->format('H:i:sA');
                $dateTime->add(new DateInterval('PT1H'));
                $end = $dateTime->format('H:i:sA');

                // Format the updated DateTime object as a string
                $updatedTimeString = $dateTime->format('Y-m-d H:i:s');
                return [
                    'id' => $appointment->id,
                    'title' => $start . ' - ' . $end,
                    'start' => $appointment->appointment_date,
                    'end' => $updatedTimeString,
                    'url' => '#'
                ];
            })
            ->all();
    }
}

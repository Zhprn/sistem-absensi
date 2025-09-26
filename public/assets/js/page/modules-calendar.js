"use strict";

$("#myEvent").fullCalendar({
    height: "auto",
    header: {
        left: "prev,next today",
        center: "title",
        right: "month,agendaWeek,agendaDay,listWeek",
    },
    // editable: true,
    initialDate: "2025-01-12",
    events: [
        {
            title: "Conference",
            start: "2025-01-9",
            end: "2025-01-11",
            backgroundColor: "#fff",
            borderColor: "#fff",
            textColor: "#000",
        },
        {
            start: "2025-01-14",
            display: "background",
            color: "#ff9f89",
        },
        {
            title: "Reporting",
            start: "2025-01-10T11:30:00",
            backgroundColor: "#f56954",
            borderColor: "#f56954",
            textColor: "#fff",
        },
        {
            title: "Starting New Project",
            start: "2025-01-11",
            backgroundColor: "#ffc107",
            borderColor: "#ffc107",
            textColor: "#fff",
        },
        {
            title: "Social Distortion Concert",
            start: "2025-01-24",
            end: "2025-01-27",
            backgroundColor: "#000",
            borderColor: "#000",
            textColor: "#fff",
        },
        {
            title: "Lunch",
            start: "2025-01-24T13:15:00",
            backgroundColor: "#fff",
            borderColor: "#fff",
            textColor: "#000",
        },
        {
            title: "Company Trip",
            start: "2025-01-28",
            end: "2025-01-31",
            backgroundColor: "#fff",
            borderColor: "#fff",
            textColor: "#000",
        },
    ],
});

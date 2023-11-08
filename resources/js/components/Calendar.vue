<template>
    <FullCalendar defaultView="dayGridMonth" :plugins="dayGridPlugin" />
</template>

<script>
import { Calendar } from "@fullcalendar/core";
import interactionPlugin from "@fullcalendar/interaction";
import dayGridPlugin from "@fullcalendar/daygrid";
import timeGridPlugin from "@fullcalendar/timegrid";
import listPlugin from "@fullcalendar/timegrid";
import axios from "axios";

var calendarEl = document.getElementById("calendar");

let calendar = new Calendar(calendarEl, {
    plugins: [interactionPlugin, dayGridPlugin, timeGridPlugin, listPlugin],
    initialView: "dayGridMonth",
    headerToolbar: {
        left: "prev,next today",
        center: "title",
        right: "dayGridMonth,timeGridWeek,listWeek",
    },
    locale: "ja",

    //日付をクリック、または範囲を選択したイベント
    selectable: true,

    //DBに登録されているイベントの呼び出し（表示）
    events: function (info, successCallback, failureCallback) {
        //Laravelのイベント取得処理の呼び出し
        axios
            .post("api/schedule-get", {
                start_date: info.start.valueOf(),
                end_date: info.end.valueOf(),
            })
            .then((response) => {
                //追加したイベントを削除
                calendar.removeAllEvents();
                //カレンダー読み込み
                successCallback(response.data);
                console.log(response);
            })
            .catch(() => {
                //バリデーションエラーなど
                alert("登録に失敗しました");
            });
    },

    //イベントの登録
    select: function (info) {
        // alert("開始日" + info.startStr + "〜" + info.endStr);

        //入力ダイアログ
        const eventName = prompt("イベントを入力してください");

        if (eventName) {
            //イベントの追加
            calendar.addEvent({
                title: eventName,
                start: info.start,
                end: info.end,
                allDay: true,
            });
            axios
                .post("/api/schedule-add", {
                    start_date: info.start.valueOf(),
                    end_date: info.end.valueOf(),
                    event_name: eventName,
                })
                .catch(() => {
                    //バリデーションエラーなどを記載
                    alert("登録に失敗しました");
                });
        }
    },

    //イベントの編集
    eventClick: function (info) {
        let title = prompt("タイトルを更新してください");
        console.log(info.event.id);

        axios
            .post("/api/schedule-update", {
                event_id: info.event.id.valueOf(),
                title,
            })
            .catch(() => {
                alert("更新に失敗しました");
            });
    },
});
calendar.render();
</script>

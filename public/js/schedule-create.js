$(function(){
    let data = localStorage.getItem('prev_schedule_data');
    if(data) {
        data = JSON.parse(data);
    } else {
        data = {};
    }

    function save() {
        localStorage.setItem('prev_schedule_data', JSON.stringify(data));
    }

    if(location.pathname == '/app/schedule/create') {
        const child = $('[name=child_id]');
        const day = $('[name=day]');
        const start_time = $('[name=start_time]');
        const end_time = $('[name=end_time]');

        if(data.child) {
            child.val(data.child);
        }
        if(data.day) {
            day.val(data.day);
        }
        if(data.start_time) {
            start_time.val(data.start_time);
        }

        child.change(function(){
            data.child = child.val();
            save();
        });

        day.change(function(){
            data.day = day.val();
            save();
        });

        end_time.change(function(){
            data.start_time = end_time.val();
            save();
        });
    }
});
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laravel Vue</title>
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script src="{{ mix('js/app.js') }}" type="text/javascript"></script>

<body>
<div id="app">
    <p :style="mobin">mobin is god</p>
    <img :alt="color" src="">
</div>
<script>
    Vue.createApp(
        {
            data() {
                return {
                    title: 'mobin is god',
                    mobin:"color:red"
                }
            }

        }
    ).mount("#app");
</script>
</body>
</html>

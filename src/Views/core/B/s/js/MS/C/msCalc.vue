
<template>

<div class="ms-clac">

    <div class="calculator">



        <div class="calc-body">
            <div class="calc-body-screen">
                <div class="q"><span id="inputtile"></span></div>
                <div class="a"><span id="answertile"></span></div>
            </div>
            <div class="calc-body-btn"><span>MC</span></div>
            <div class="calc-body-btn"><span>MR</span></div>
            <div class="calc-body-btn"><span>MS</span></div>
            <div class="calc-body-btn"><span>M+</span></div>
            <div class="calc-body-btn"><span>M-</span></div>
            <div id="btn_back" class="calc-body-btn"><span>←</span></div>
            <div id="btn_clear_all" class="calc-body-btn"><span>CE</span></div>
            <div id="btn_clear" class="calc-body-btn"><span>C</span></div>
            <div id="btn_rvnag" class="calc-body-btn"><span>±</span></div>
            <div id="btn_sqrt" class="calc-body-btn"><span>√</span></div>
            <div class="calc-body-btn btnnum"><span>7</span></div>
            <div class="calc-body-btn btnnum"><span>8</span></div>
            <div class="calc-body-btn btnnum"><span>9</span></div>
            <div class="calc-body-btn btnnum"><span>/</span></div>
            <div class="calc-body-btn btnnum"><span>%</span></div>
            <div class="calc-body-btn btnnum"><span>4</span></div>
            <div class="calc-body-btn btnnum"><span>5</span></div>
            <div class="calc-body-btn btnnum"><span>6</span></div>
            <div class="calc-body-btn btnnum"><span>＊</span></div>
            <div id="btn_reverse" class="calc-body-btn"><span>1/x</span></div>
            <div class="left">
                <div class="calc-body-btn btnnum"><span>1</span></div>
                <div class="calc-body-btn btnnum"><span>2</span></div>
                <div class="calc-body-btn btnnum"><span>3</span></div>
                <div class="calc-body-btn btnnum"><span>-</span></div>
                <div class="calc-body-btn zero btnnum"><span>0</span></div>
                <div class="calc-body-btn btnnum"><span>.</span></div>
                <div class="calc-body-btn btnnum"><span>+</span></div>
            </div>
            <div id="btn_cal_all" class="calc-body-btn qu"><span>=</span></div>
        </div>



    </div>


</div>
</template>


<script>
    export default {
        name: "mscalc"
    }
</script>

<style scoped>



    .calculator {
        width: 100%;
        height: 100%;
        min-height: 600px;
        background-image: linear-gradient(to bottom, #038FA1, #023E6E);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 2501;
    }
    .calc-body {
        width: 85%;
        max-width: 250px;
        height: 375px;
        background-image: linear-gradient(to bottom, #004D59, #012024);
        padding: 10px;
        border-radius: 10px;
        box-shadow: 0 25px 35px -15px rgba(3, 28, 31, .85);
        /*flex*/
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: stretch;
        align-content: space-between;
    }
    .calc-body-screen {
        flex: 1 0 100%;
        height: 24%;
        color: #A8EEFF;
        box-shadow: inset 0 0 0 1px #225861;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        text-align: right;
    }
    .calc-body-screen .q {
        width: 100%;
        line-height: 40px;
        padding: 0 5%;
        box-sizing: border-box;
        font-size: 15px;
    }
    .calc-body-screen .a {
        line-height: 50px;
        width: 100%;
        padding: 0 5%;
        box-sizing: border-box;
        font-size: 38px;
    }
    .calc-body-btn {
        cursor: pointer;
        opacity: .6;
        font-size: 12px;
        flex: 0 1 18%;
        height: 11%;
        color: #A8EEFF;
        box-shadow: inset 0 0 0 1px #225861;
        text-align: center;
        border-radius: 5px;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .calc-body-btn:hover {
        background-color: #225861;
    }
    .calc-body-btn.qu {
        height: 23%;
    }
    .left {
        display: flex;
        flex: 0 0 79.5%;
        height: 23%;
        align-content: space-between;
        justify-content: space-between;
        flex-wrap: wrap;
    }
    .left .calc-body-btn {
        height: 46%;
        flex: 0 0 23%;
    }
    .left .calc-body-btn.zero {
        flex: 0 1 48.5%;
    }
</style>

<template>
<div>
  <el-container>
    <el-header>
        <el-row>
            <el-col :span="12">
                <div class="grid-content">
                    <img src="https://www.fofxacademy.com/wp-content/uploads/2018/11/fofx_white.png" alt="">
                </div>
            </el-col>
            <el-col :span="12" style="text-align:right;" class="d-none d-xl-block">
                <div class="grid-content">
                    <span style="font-size:20px;">{{date}} || <span style="font-size:20px;" id="txt"></span></span>
                    <el-dropdown>
                        <i class="el-icon-setting ml-5" style="font-size:20px;color:#fff;"></i>
                        <el-dropdown-menu slot="dropdown">
                        <el-dropdown-item>View Attendance</el-dropdown-item>
                        </el-dropdown-menu>
                    </el-dropdown>
                </div>
            </el-col>
        </el-row>
    </el-header>

</el-container>

</div>
</template>

<style>
  .el-header {
    background-color:#0273be;
    color: #fff;
    height:auto;
    line-height: 60px;
  }

  img{
    min-width:30%;
    max-height:60px;
  }

</style>

<script>
export default {
        data(){
            return{
                date: '',
            }
        },

        mounted(){
            setInterval(this.startTime, 1000);
            this.startTime();
            this.getDate();
        },

        methods:{
            getDate(){
                var date = new Date();

                return this.date = date.getDate() + "-" + (date.getMonth()+1) + "-" + date.getFullYear();
            },

            startTime() {
                var today = new Date();
                var h = today.getHours();
                var m = today.getMinutes();
                var s = today.getSeconds();
                m = this.checkTime(m);
                s = this.checkTime(s);
                document.getElementById('txt').innerHTML =
                h + ":" + m + ":" + s;
            },

            checkTime(i) {
                if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
                return i;
            }
        },
    }
</script>

  function newFunction() {
    console.log("gh");
  }

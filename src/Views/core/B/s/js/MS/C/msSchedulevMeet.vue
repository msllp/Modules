<template>

    <div>



        <div class="ms-vMeet-container">
            <div class="ms-vMeet-col">
                <div class="ms-vMeet-contact-list-title">
                    Select User to Include in Virtual Meet
                </div>
                <table class="ms-vMeet-contact-list-table">

                    <thead>

                    </thead>
                    <tbody>
                    <tr v-for="(row,key) in allUser" class="ms-vMeet-contact-list-tr" v-on:click="toggleUser(row.id)">
                        <td class="ms-vMeet-userCheck" ><input type="checkbox" :value="row.id" v-model="selctedUsers"></td>
                        <td class="ms-vMeet-userName" >{{row.name}}</td>
                        <td class="ms-vMeet-companyName" >{{(row.CompanyId =! '0')?row.CompanyId :'No Company Assined'}}</td>
                    </tr>

                    <tr>
                        <th  colspan="3">
                            Total Selected User: {{selctedUsers.length}}
                        </th>
                    </tr>
                    </tbody>
                </table>

            </div>
            <div class="ms-vMeet-col">
                <div class="ms-vMeet-minutes-list-title">
                    Minutes of meeting
                </div>
                <table class="ms-vMeet-minutes-table">
                    <tbody>
                    <tr>
                        <td colspan="2">
                            <textarea rows="2" cols="50" v-model="msCurrentMin"  class="ms-vMeet-minutes-input"></textarea>
                        </td>
                        <td class="ms-vMeet-minutes-add-btn" v-on:click="addMin">
                        Add Minute
                        </td>

                    </tr>
                    <tr v-for="(row,key) in allMinutes" class="ms-vMeet-minutes-table-tr" >
                        <td> {{key+1}} </td>
                        <td class="ms-vMeet-Title" >{{row}}</td>
                        <td class="ms-vMeet-Delete" ></td>
                    </tr>

                    <tr>
                        <th  colspan="3">
                            Total Minutes : {{allMinutes.length}}
                        </th>
                    </tr>
                    </tbody>
                </table>

            </div>

        </div>




    </div>

</template>


<script>
    export default {
        name: "msvmeet",
        props: {
            'msData': {
                type: Object,
                required: true,

                }
            },
        data(){
          return{
              allUser:(this.msData.hasOwnProperty('allowedUser'))?this.msData.allowedUser:[],
              selctedUsers: [],
              allMinutes:[],
              msCurrentMin:null

          }
        },

        mounted() {

        },
        methods:{
            toggleUser(id){

                if(this.selctedUsers.includes(id)){

                    var index = this.selctedUsers.indexOf(id);
                    if (index > -1) {
                        this.selctedUsers.splice(index, 1);
                    }

                }else {
                    this.selctedUsers.push(id);
                }
             //   console.log(user);
            },
            addMin() {
                if (!this.allMinutes.includes(this.msCurrentMin) && this.msCurrentMin!=null) {
                    this.allMinutes.push(this.msCurrentMin);
                    this.msCurrentMin=null;
                }
            }
        }

    }
</script>

<style scoped>

</style>

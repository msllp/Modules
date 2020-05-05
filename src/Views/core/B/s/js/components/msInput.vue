<template>
    
</template>

<script>

    import  MS  from '../MS';
    import  MDD from 'mobile-device-detect';
    export default {
        name: "msinput",
        mixins: [MS,MDD],
        props:{
            'msData':{
                type: Object,
                required: true
            },
            'msGroupIndex':{
                type: Number,
                required: true
            }
        },
        data: function () {
            return {
                msValid: 0,
                msValue:'',
                msMinCharValidation:0,
                inputValidation:[],
                inputAuto:[],
                inputError:new Object(),
                inputName:'',//
                inputVname:'',
                inputPrefix:'',
                inputPerfix:'',
                inputOnly:false,
                inputType:'text',
                inputRequired:false,
                dValue:'',
                dText:'',
                finalInput:new Object({}),
                inputMultiple:false,
                inputCount:0,
                groupInput:[],//
                inputInfo:"",
            }
        },

    methods:{

            isOlOK(){

            }

    }
    }
</script>

<style scoped>

</style>

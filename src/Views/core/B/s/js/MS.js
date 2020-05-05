export default {
    methods: {

        validatePassword (pass,length=8,strenth=3) {

            switch (strenth) {
                case 1:
                    var re = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.{"+length+",})");
                    break;

                case 2:
                    var re = new RegExp("^(?=.*[a-z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{"+length+",})");
                    break;

                case 3:
                    var re = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{"+length+",})");
                    break;

                default:
                    var re = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{"+length+",})");
                    break;
            }
            return re.test(pass);
        },

        validateLen(str,size=1){

            var re = new RegExp("^(?=.{"+size+",})");
            return  re.test(str);
        },

        getGetLink(url,classFor){
            url=url+"?dataLink=true"
            var returnX="";
            var self = classFor ;

            let re= axios.get(url)
                .then(
                    function(response){
                        returnX=response.data;
                        self.setHtml(returnX);

                    }
                )
                .catch(function (error) {
                    // handle error
                    self.setMsError(error.response.data);
                    //  console.log(error.response.data);
                })
                .finally( response => {
                });



        },
        postLink(link,data,classFor){
            var Freturn={};


            axios.post(link, data,{headers: {
                    'content-type': 'multipart/form-data',
                    // 'charset':'utf-8',
                    'boundary':Math.random().toString().substr(2),
                    'Accept': "application/json",
                    'maxContentLength':Math.random().toString().substr(2)
                }})
                .then(function (response) {
                    //console.log(response);
                    Freturn.data=response.data;
                })
                .catch(function (error) {
                    Freturn.error=error.response.data.errors;
                   // console.log(error.response.data);
                    classFor.setAllMsError(Freturn.error);
                    //  delete Freturn.error.message;


                });
            return Freturn;
            //  console.log(Freturn);
        },



        makeArrayForInput(base){
            var self = base ;

            var id= base.inputName;
            var vName=base.inputVname;
            var re = {
                id: id,
                label: 'Enter ' + vName,
                baseValue: base
            };
            if(base.inputMultiple) {
                re.id = id + "[]";
                re.label = 'Enter ' + vName;

            }
            //    console.log(re);
            //   base.setFinalInput(re);
            return re;
            // console.log(re);
            // return [re];
        },
        makeArrayForInputGroup(base,id,index){
            var self=base;
            var idfor=id+"_"+index;
            var Inputindex=1
            //  console.log(self.msFormData[id])

            Inputindex =base.msCount[id] -1 ;
            var fordata={
                rootId:id,
                id:index,
                groupDynamic:true,
                gruoupHeading:self.msFormData[id].gruoupHeading+" No of: " + Inputindex ,
                inputs:self.msFormData[id].inputs

            }
            return fordata;
        }
        ,
        in_array(value,array){
            return array.includes(value);
        },
        get_time_diff( datetime ){
            var datetime = typeof datetime !== 'undefined' ? datetime : "2014-01-01 01:02:03.123456";

            var datetime = new Date( datetime ).getTime();
            var now = new Date().getTime();

            if( isNaN(datetime) )
            {
                return "";
            }

            //console.log( datetime + " " + now);

            if (datetime < now) {
                var milisec_diff = now - datetime;
            }else{
                var milisec_diff = datetime - now;
            }

            var days = Math.floor(milisec_diff / 1000 / 60 / (60 * 24));

            var date_diff = new Date( milisec_diff );

            return date_diff.getMilliseconds();
        },
        roundToTwo(num) {
            //    console.log(num);
            //  console.log(Math.round(num)     );
            return Math.round(num);
        },
        calc_get_prapotion(totalValue,secondValue ){
            var returnValue=0;


            returnValue =   (secondValue*100)   / totalValue ;


            return this.roundToTwo(returnValue) ;
        },
        check_uniq(setArray,baseArray){
            for ( var i = 0 ; i < baseArray.length; i++ ){
                if(this.in_array(baseArray[i],setArray))return false;
            }
            return true;
        },

        isMobile() {
            //     return true

            var str=navigator.platformt;
            //var n = str.search("Windows");
            console.log(navigator.platform);
            //if(n >0 )
            if( (str  == 'Android') || (str  == 'iPhone') || (str  == 'iPod') || (str  == 'iPad') || (str  == 'BlackBerry') || (str  == 'Pocket PC') || (str  == 'webOS')  || (str == "Linux armv8l") ) {
                return true
            } else {
                return false
            }
        }

        ,
        forNice(str){
            var txt=str;
            return txt.toLowerCase()
                .split(' ')
                .map((s) => s.charAt(0).toUpperCase() + s.substring(1))
                .join(' ');
        },

        ms_rand(length,type=1) {

            switch (type) {

                case 1:
                var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                break;

                case 2:
                    var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
                    break;

                case 3:
                    var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                    break;

                case 4:
                    var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789~!@#$%^&*()_+{}|:';
                    break;

            }
    var result           = '';

    var charactersLength = characters.length;
    for ( var i = 0; i < length; i++ ) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
    return result;
}
    },


}

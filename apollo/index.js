$(function(){
  $('#loading').css('display','none');
  $('#jumbo').css('display','block');
    /*make ajax call*/
    $.ajax({
        type:'GET',
        url:"https://min-api.cryptocompare.com/data/pricemulti?fsyms=ETH,BTC,LTC,XRP,XMR&tsyms=INR",
        success:function(json){
            switch (gup("cur",window.location.href)) {
                case 'BTC':
                $(".current").html(" ₹ "+json.BTC.INR);
                break;
                case 'ETH':
                $(".current").html(" ₹ "+json.ETH.INR);
                break;
                case 'XMR':
                $(".current").html(" ₹ "+json.XMR.INR);
                break;
                case 'XRP':
                $(".current").html(" ₹ "+json.XRP.INR);
                break;

            }
            $(".btc").html("₹ "+json.BTC.INR);
            $(".eth").html("₹ "+json.ETH.INR);
            $(".mon").html("₹ "+json.XMR.INR);
            $(".rip").html("₹ "+json.XRP.INR);
        },
        error:function(err){
            console.log(err);
        }
    });
    var d=new Date();
    $(".live_time").html("Updated at "+d.getHours()+":"+d.getMinutes()+" IST");


});

function gup( name, url ) {
    if (!url) url = location.href;
    name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
    var regexS = "[\\?&]"+name+"=([^&#]*)";
    var regex = new RegExp( regexS );
    var results = regex.exec( url );
    return results == null ? null : results[1];
}
function precisionRound(number) {
  var factor = Math.pow(10, 2);
  return Math.round(number * factor) / factor;
}
function passData(btc,eth,xmr,xrp,best,worst)
{
    $(".date").html(""+new Date().toISOString().slice(0, 10));
    console.log(best);
    console.log(worst);
    var prediction_time = new Date().getTime()/100000000;
    var chart = new CanvasJS.Chart("chartContainer", {
        // title: {
        // 	text: "Adding & Updating dataPoints"
        // },
        axisY: {
            title: "Price in ₹",
            prefix: "₹"
        },
        zoomEnabled: true,
        axisX: {
            title: "Time"
        },
        legend: {
            horizontalAlign: "center", // left, center ,right
            verticalAlign: "bottom",  // top, center, bottom
        },
        data: [
            {
                type: "splineArea",
                color: "rgba(0,123,255)",
                legendText: "Bitcoin",
                showInLegend: true,
                dataPoints: [
                ]
            },

            {
                type: "splineArea",
                color: "rgba(255,193,7)",
                legendText: "Ethereum",
                showInLegend: true,
                dataPoints: [
                ]
            },
            {
                type: "splineArea",
                color: "rgba(40,167,69)",
                legendText: "Monero",
                showInLegend: true,
                dataPoints: [
                ]
            },
            {
                type: "splineArea",
                color: "rgba(220,53,69)",
                legendText: "Ripple",
                showInLegend: true,
                dataPoints: [
                ]
            },
            {
                type: "spline",
                color: "rgba(0,123,255)",
                legendText: "Current Value",
                showInLegend: true,
                dataPoints: [
                ]
            },
            {
                type: "spline",
                color: "rgba(255,193,7)",

                legendText: "Predicted Value",
                showInLegend: true,
                dataPoints: [
                ]
            }
        ]
    });
   var milliseconds = new Date().getTime();

    if(gup("cur",window.location.href)=='BTC')
    {
        for(var i=0;i<btc.length;i++)
        {
            if(parseInt(btc[i].timestamp/100000)==parseInt(prediction_time))
            {
              var pred=(btc[i].prediction*65);
                $(".predicted").html(" ₹ "+precisionRound(pred));
                $.ajax({
                    type:'GET',
                    url:"https://min-api.cryptocompare.com/data/pricemulti?fsyms=BTC&tsyms=INR",
                    success:function(json){
                      var cur=json.BTC.INR;
                      if(cur>pred)
                      $(".accuracy").html(precisionRound(100-((cur-pred)/cur*100))+" %");
                      else
                      $(".accuracy").html(precisionRound(100-((pred-cur)/cur*100))+" %");
                    },
                    error:function(err){
                        console.log(err);
                    }
                });
            }


            var a = new Date(btc[i].timestamp * 1000);
            if(btc[i].close!=-1)
            chart.options.data[4].dataPoints.push({x:new Date(a.getFullYear(),a.getMonth(),a.getDate()),y:parseInt(btc[i].close*65)});
            chart.options.data[5].dataPoints.push({x:new Date(a.getFullYear(),a.getMonth(),a.getDate()),y:parseInt(btc[i].prediction*65)});

            $(".bestdate").html(best[0].date.slice(0, 10));
            $(".best").html(" ₹ "+precisionRound(best[0].prediction*65));
            $(".worstdate").html(worst[0].date.slice(0, 10));
            $(".worst").html(" ₹ "+precisionRound(worst[0].prediction*65));

        }
    }
    else
    if(gup("cur",window.location.href)=='ETH')
    {

        for(var i=0;i<eth.length;i++)
        {
            if(parseInt(eth[i].timestamp/100000)==parseInt(prediction_time))
            {
              var pred=(eth[i].prediction*65);
                $(".predicted").html(" ₹ "+precisionRound(pred));
                $.ajax({
                    type:'GET',
                    url:"https://min-api.cryptocompare.com/data/pricemulti?fsyms=ETH&tsyms=INR",
                    success:function(json){
                      var cur=json.ETH.INR;
                      if(cur>pred)
                      $(".accuracy").html(precisionRound(100-((cur-pred)/cur*100))+" %");
                      else
                      $(".accuracy").html(precisionRound(100-((pred-cur)/cur*100))+" %");
                    },
                    error:function(err){
                        console.log(err);
                    }
                });
            }

            var a = new Date(eth[i].timestamp * 1000);
            if(eth[i].close!=-1)
            chart.options.data[4].dataPoints.push({x:new Date(a.getFullYear(),a.getMonth(),a.getDate()),y:parseInt(eth[i].close*65)});
            chart.options.data[5].dataPoints.push({x:new Date(a.getFullYear(),a.getMonth(),a.getDate()),y:parseInt(eth[i].prediction*65)});

            $(".bestdate").html(best[0].date.slice(0, 10));
            $(".best").html(" ₹ "+precisionRound(best[0].prediction*65));
            $(".worstdate").html(worst[0].date.slice(0, 10));
            $(".worst").html(" ₹ "+precisionRound(worst[0].prediction*65));
        }
    }
    else
    if(gup("cur",window.location.href)=='XMR')
    {
        for(var i=0;i<xmr.length;i++)
        {
            if(parseInt(xmr[i].timestamp/100000)==parseInt(prediction_time))
            {
                var pred=(xmr[i].prediction*65);
                  $(".predicted").html(" ₹ "+precisionRound(pred));
                $.ajax({
                    type:'GET',
                    url:"https://min-api.cryptocompare.com/data/pricemulti?fsyms=XMR&tsyms=INR",
                    success:function(json){
                      var cur=json.XMR.INR;
                      if(cur>pred)
                      $(".accuracy").html(precisionRound(100-((cur-pred)/cur*100))+" %");
                      else
                      $(".accuracy").html(precisionRound(100-((pred-cur)/cur*100))+" %");
                    },
                    error:function(err){
                        console.log(err);
                    }
                });
            }

            var a = new Date(xmr[i].timestamp * 1000);
            if(xmr[i].close!=-1)
            chart.options.data[4].dataPoints.push({x:new Date(a.getFullYear(),a.getMonth(),a.getDate()),y:parseInt(xmr[i].close*65)});
            chart.options.data[5].dataPoints.push({x:new Date(a.getFullYear(),a.getMonth(),a.getDate()),y:parseInt(xmr[i].prediction*65)});

            $(".bestdate").html(best[0].date.slice(0, 10));
            $(".best").html(" ₹ "+precisionRound(best[0].prediction*65));
            $(".worstdate").html(worst[0].date.slice(0, 10));
            $(".worst").html(" ₹ "+precisionRound(worst[0].prediction*65));
        }
    }
    else
    if(gup("cur",window.location.href)=='XRP')
    {
        for(var i=0;i<xrp.length;i++)
        {
            if(parseInt(xrp[i].timestamp/100000)==parseInt(prediction_time))
            {
                var pred=(xrp[i].prediction*65);
                $(".predicted").html(" ₹ "+precisionRound(pred));
                $.ajax({
                    type:'GET',
                    url:"https://min-api.cryptocompare.com/data/pricemulti?fsyms=XRP&tsyms=INR",
                    success:function(json){
                        var cur=json.XRP.INR;
                        if(cur>pred)
                        $(".accuracy").html(precisionRound(100-((cur-pred)/cur*100))+" %");
                        else
                        $(".accuracy").html(precisionRound(100-((pred-cur)/cur*100))+" %");
                    },
                    error:function(err){
                        console.log(err);
                    }
                });
            }

            var a = new Date(xrp[i].timestamp * 1000);
            if(xrp[i].close!=-1)
            chart.options.data[4].dataPoints.push({x:new Date(a.getFullYear(),a.getMonth(),a.getDate()),y:parseInt(xrp[i].close*65)});
            chart.options.data[5].dataPoints.push({x:new Date(a.getFullYear(),a.getMonth(),a.getDate()),y:parseInt(xrp[i].prediction*65)});

            $(".bestdate").html(best[0].date.slice(0, 10));
            $(".best").html(" ₹ "+precisionRound(best[0].prediction*65));
            $(".worstdate").html(worst[0].date.slice(0, 10));
            $(".worst").html(" ₹ "+precisionRound(worst[0].prediction*65));
        }
    }
    else {
    	$("#jumbo").css("display","none");
        for(var i=0;i<btc.length;i++)
        {
            var a = new Date(btc[i].timestamp * 1000);
            chart.options.data[0].dataPoints.push({x:new Date(a.getFullYear(),a.getMonth(),a.getDate()),y:parseInt(btc[i].close*65)});
        }
        for(var i=0;i<eth.length;i++)
        {
            var a = new Date(eth[i].timestamp * 1000);
            chart.options.data[1].dataPoints.push({x:new Date(a.getFullYear(),a.getMonth(),a.getDate()),y:parseInt(eth[i].close*65)});
        }
        for(var i=0;i<xmr.length;i++)
        {
            var a = new Date(xmr[i].timestamp * 1000);
            chart.options.data[2].dataPoints.push({x:new Date(a.getFullYear(),a.getMonth(),a.getDate()),y:parseInt(xmr[i].close*65)});
        }
        for(var i=0;i<xrp.length;i++)
        {
            var a = new Date(xrp[i].timestamp * 1000);
            chart.options.data[3].dataPoints.push({x:new Date(a.getFullYear(),a.getMonth(),a.getDate()),y:parseInt(xrp[i].close*65)});
        }
    }
    chart.render();
}

  function getQueryVariable(variable) {
    var query = window.location.search.substring(1);
    var vars = query.split('&');
    for (var i = 0; i < vars.length; i++) {
        var pair = vars[i].split('=');
        if (decodeURIComponent(pair[0]) == variable) {
            return decodeURIComponent(pair[1]);
        }
    }
    console.log('Query variable %s not found', variable);
}

  if (typeof manual == 'undefined' || !manual) {manual = false;}
  if (typeof registering == 'undefined') {registering = false;} 

if (manual && !getQueryVariable("type")) {
  window.location.href = window.location.hostname + window.location.pathname + "?type=registration";
}



  var type = getQueryVariable("type");
  if (manual && type) {
    if (type == 'registration') {
      registering = true;
    }
    else {
      registering = false;
    }
  }
 function animate($box) {
  var minTop = $box.find(".register").offset().top;
  if ($('body')[0].scrollTop < minTop) {
    $('html, body').animate({
      scrollTop: minTop
    }, 500);
  }
 }
 $(function() {
  var team = getQueryVariable("t");
  if (team) {
    //when you go to http://walkathon.chinmayamissionalpharetta.org/donate/?t=Niyama and click "register instead", it should go to http://walkathon.chinmayamissionalpharetta.org/register/?t=Niyama and auto-select this team here. 
    $("a.registerInstead").attr("href","/register?t="+team);
    $("select[name=team]").val(team);
  }

  $(".teamDetailsShow").hide();
  //var team = $(".teamNameDiv").data("name");
  var team = window.team;
  console.log(team);
  if (typeof team != 'undefined' && team) {
    $("select[name=team]").val(team); $(".teamDetailsHide").hide(); $(".teamDetailsShow").show();}
  if (registering) {
    $(".registerShow").show();
    //$(".donateShow :input").prop('required',null);
    $(".donateShow").remove();
    $("input[name=type]").val("registration");
  } else {
    $(".donateShow").show();
    //$(".registerShow :input").prop('required',null);
    $(".registerShow").remove();
    $("input[name=type]").val("donation");
  }
  if (!registering) {
    $(".donateAmountsDiv .btn").click(function() {
      $(".additionalDonation").val(parseInt($(this).text().replace(/\$/g, "")));
      updateTotal();
    });
    var $donateRegParent = $(".donateRegParent");
    $(".AteamDiv a").click(function(e) {
      e.preventDefault();
      //$donateRegParent.slideDown();
      $("select[name=team]").val($(this).data("team"));
      scrollTo($donateRegParent);
    });
  }
  if (registering) {
    var range = "B9:B20";
    $.get("https://sheets.googleapis.com/v4/spreadsheets/1eXYberMxmy8c9vV4N1_pM1WyE5AVcNgiK9YKkApIw0U/values/Aggregate%20individual%20stats!"+range+"?key=AIzaSyBG2JJkYhiFHwhvQn_vGMcZihbwIBxvS_o&majorDimension=COLUMNS", function(res) {
      //console.log(res);
      var n = 0;
      $("select[name=team] > option").not(".default").each(function() {
        var name = res.values[0][n];
        if (name == "Yuva") {
          name+= " (Grades 9-12)";
        }
        if (name == "Bala") {
          name+= " (Grades 1-8)";
        }
        $(this).text($(this).text() + " - "+name+ " walkers registered");
        n++;
      })
    });
  }
  var $inputAddr = $("input[name=address]");
  var options = {                    
    types: ["address"]
  };
  var autocomplete = new google.maps.places.Autocomplete($inputAddr[0], options);
   autocomplete.addListener('place_changed', function() {
     var place = autocomplete.getPlace();
     var zipcode = "";
     console.log(place.address_components);
     for (i in place.address_components) {
      if (place.address_components[i].types[0] == "postal_code") {
        zipcode = place.address_components[i]["short_name"];
        break;
      }
     }
     $inputAddr.val($inputAddr.val() + " " + zipcode);
   });


  var total = 0;
  $("input").keyup(function() {
    updateTotal();
  });
  $("input").change(updateTotal);
  var round = "none";
  $("input:radio[name=round]").change(function() {
    var thisParent = $(this).parent("label");
    $("input:radio[name=round]").parent("label").not(thisParent).addClass("btn-default").removeClass("active");
    thisParent.removeClass("btn-default").addClass("active");
    round = $(this).val();
    updateTotal();
  });

  $("input:radio[name=emailSub]").change(function() {
    var thisParent = $(this).parent("label");
    $("input:radio[name=emailSub]").parent("label").not(thisParent).addClass("btn-default").removeClass("active");
    thisParent.removeClass("btn-default").addClass("active");
    $("input[name=emailSubInput]").val($(this).val());
    updateTotal();
  });
  $("select").change(updateTotal);

  function updateTotal() {
    total = 0;
    if (registering) { 
      for (i = 0; i <= 5; i++) {
        if ($("input[name=name" + i + "]").val()) {
          var regularPrice = new Date() > new Date("05/01/2017");
          var age = $("select[name=age" + i + "]").val();
          if (age == "Adult") {
            total += regularPrice ? 25 : 20;
          } else if (parseInt(age) <= 12) {
            if (parseInt(age) >= 9) {
              total += regularPrice ? 25 : 20;
            } else {
              total += regularPrice ? 20 : 15;
            }
          } else {
            total += regularPrice ? 20 : 15;
          }
        }
      }
    }
    var additional = parseInt($(".additionalDonation").val());
    total += additional ? additional : 0;
    if (round == "yes") {
      if (total == 0) total = .1;
      total = Math.ceil(total / 100) * 100;
    }
    $(".subTotal").text(total);
    var fee = Math.round(total * .025 + .25);
    if (manual) { fee = 0; }
    $(".fee").text(fee);
    total += fee;
    $(".totalCost").text(total);
    $("input[name=amount]").val(total);
  }
  window.fill = function() {
    $("input[name=email]").val("a@b.com");
    $("input[name=address]").val("10570 victory gate dr johns creek ga 30022");
    $("input[name=phone]").val("7705159732");
    $("input[name=name1]").val("Ashwin");
    $("select[name=age1] option").attr("selected", "selected");
    $("select[name=size1]").val("Adult Large");
    $($("select[name=team]").children("option")[1]).attr("selected", "selected");
    $("input[type=radio]").click();
    updateTotal();
  }

if (getQueryVariable("dev")) {
  window.developer = true;

}
   if (getQueryVariable("dev")) {
      fill();
      updateTotal();
      //setTimeout($("form").submit(), 5000);
   }
  if (!manual) {
    $("input[name=paid]").remove();
    $(".manualShow").hide();
  }
  else {
    $("input[name=paid]").show().attr("required","required");
    $(".manualShow").removeClass("manualShow");
  }

if (manual) {

  function replaceQueryString(url,param,value) {
    var re = new RegExp("([?|&])" + param + "=.*?(&|$)","i");
    if (url.match(re))
        return url.replace(re,'$1' + param + "=" + value + '$2');
    else
        return url + '&' + param + "=" + value;
  }

    $(".manualShow").show();
    $("input[name=type]").replaceWith("<div class='col-xs-12 text-center'>Registration or donation? <select name=type class=manualTypeSelect><option>registration</option><option>donation</option></select></div>");
  $("[name=type]").val(getQueryVariable("type"));
  $(".manualTypeSelect").change(function() {
    window.location.href = replaceQueryString(window.location.href, 'type', $(this).val());
  })
 
}

  if (true) {
    $('form').on('submit', submitFn);
  }
      $(function() {
      $(".developer").hide();
    if (window.developer) {
      //$(".developer").show();
      //$("button.developer").click(submitFn);
     
    }
  });
  
  function submitFn(e) {
    // this code prevents form from actually being submitted
    if (e) {
      e.preventDefault();
      e.returnValue = false;
    }
    // some validation code here: if valid, add podkres1 class
    if (registering) {
      for (i = 0; i <= 5; i++) {
        if ($("input[name=name" + i + "]").val()) {
          if (!$("select[name=age" + i + "]").val()) {
            alert("Please select an age for " + $("input[name=name" + i + "]").val());
            return;
          }
          if (!$("select[name=size" + i + "]").val()) {
            alert("Please select a t-shirt size for " + $("input[name=name" + i + "]").val());
            return;
          }
        }
      }
    }
    if ($("select[name=team]").length && !$("select[name=team]").val()) {
      alert("Please select a team.");
      return;
    }
    if (!$("input[name=address]").val().trim().match(/^\d/)) {
      //address starts with number
      alert("Please enter a valid home address. Address must start with a house number and end with a zip code.");
      return;
    }
    if (window.onecent) {
      total = ".00";
      $("input[name=amount]").val(total);
    }
    if (parseInt(total) <= 0) {
      alert("Please donate a valid amount.");
      return;
    }
    $.blockUI();
    var $form = $("form");
    // this is the important part. you want to submit
    // the form but only after the ajax call is completed
    var id = new Date().getTime();
    id = id.toString();
    var data = {
        "email": $("input[name=email]").val(),
        "emailSub": $("input[name=emailSubInput]").val(),
        "address": $("input[name=address]").val(),
        "phone": $("input[name=phone]").val(),
        "team": $("[name=team]").val(),
        "total": total,
        "type": $("[name=type]").val(),
        "additionalDonation": $("input.additionalDonation").val(),
        "name1": $("input[name=name1]").val(),
        "age1": $("select[name=age1]").val(),
        "size1": $("select[name=size1]").val(),
        "name2": $("input[name=name2]").val(),
        "age2": $("select[name=age2]").val(),
        "size2": $("select[name=size2]").val(),
        "name3": $("input[name=name3]").val(),
        "age3": $("select[name=age3]").val(),
        "size3": $("select[name=size3]").val(),
        "name4": $("input[name=name4]").val(),
        "age4": $("select[name=age4]").val(),
        "size4": $("select[name=size4]").val(),
        "name5": $("input[name=name5]").val(),
        "age5": $("select[name=age5]").val(),
        "size5": $("select[name=size5]").val(),
        "id": id,
        "promoCode": $("input[name=promoCode]").val(),
        "referred": $("input[name=referred]").val(),
      };
      console.log(id);
    if (manual) {
      data["paid"] = $("select[name=paid]").val();
    }
    if ($("input[name=promoCode]").val().trim()) {
      data["paid"] = $("input[name=promoCode]").val();
      data["total"] = 0;
    }
    var url = 'https://script.google.com/macros/s/AKfycbxkISCiEExWwCfvNFh5YtRAKtvTpc3qk0hahdCbZbUxw82rTrY4/exec';
    if (window.developer) {
      url = "/processregistration/";
    }
    url = "/processregistration/";
    $.ajax({
      type: 'post',
      data: data,
      url: url,
      context: $form, // context will be "this" in your handlers
      error: function(e) { // your error handler
        $.unblockUI();
        alert("Sorry, there was an error. Please try again later.");
        if (window.developer) {
          alert(JSON.stringify(e));
        }
      },
      success: function(response) {
        // make sure that you are no longer handling the submit event; clear handler
        try {
          if (JSON.parse(response).redirect === false) {
            alert("Complimentary registration with promo code completed successfully. Thank you for supporting CMA!")
            location.reload();
            return;
          }
          else if ($("input[name=promoCode]").val().trim()) {
            alert("Promo code was not correct. Please reenter the promo code.");
            $("input[name=promoCode]").val("");
            $.unblockUI();
            return;
          }
        }
        catch (e) {

        }
        $(this).off('submit');
        var preText = "Registration";
        if (!registering) preText = "Donation";
        console.log(id);
        var nameText=preText+ " - Walkathon ID " + id + " - " + $("[name=team]").val() + " - " + $("input[name=email]").val() + " - $" + $(".subTotal").text() + " registration fee plus $" + $(".fee").text() + " PayPal transaction fee";
        $("input[name=item_name]").val(nameText).attr("value", nameText);
        $("input[name=custom]").val(id).attr("value",id);
        // actually submit the form
        if (!manual) {
          $(this).attr("action", $(this).data("action"));
          this.submit();
        }
        else {
          alert("Registration completed successfully.");
          location.reload();
        }
      },
      complete: function(response) {}
    });

    return false;
  }
 });
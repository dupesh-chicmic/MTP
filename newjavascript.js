function hideOthers(carsLength) {
      for (i = 0; i < carsLength; i++) { 
        if ($("#tab_"+i).exists()) {
            document.getElementById(\'tab_\'+i).innerHTML="";
        }
        
      }
    }
function verify(){
        if(document.asset.AssetName.value=="") {
            alert("enter the valid Assetname");
         //  document.getElementById("demo").innerHTML="enter the valid Asset Name";
            return false;}  
            else if (document.asset.AssetType.value=="") {
            alert("enter the valid AssetType");
            //document.getElementById("demo").innerHTML="enter the valid AssetType";
            document.asset.AssetType.focus();
            return false;}  else if (document.asset.AssetDesc.value==""){
		    alert("enter the valid AssetDesc");
		    //document.getElementById("demo").innerHTML="enter the valid AssetDesc";
		    return false;}  else if (document.asset.AssetStatus.value== ""){
		    alert("Enter the valid AssetStatus");
		    //document.getElementById("demo").innerHTML="Enter the valid AssetStatus";
		    return false;} else {
		    return true;
		}
	}

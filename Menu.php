<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title></title>
    <script type="text/javascript">
        function Go2HOME(path) {
            window.location.href = path + "Home.php"
            window.frames['SideBar'].changeColour("X");
        }

        function Exit(path) {
            window.location.href = path + "index.php"
            self.close();
        }


        function SessionLost(path) {
            window.location.href = path + "index.php"                
        }
    </script>
    <script type="text/javascript" language="javascript">
        
        function createproject(path) {
                window.location.href = path + "project.php";
                // window.location.href = path + "projectbrowse.php";
                window.frames['SideBar'].changeColour("F2");
                //window.frames['SideBar'].document.getElementById('S1').style.fontWeight ='100';
        }
        
        function createworkflow(path) {                
                window.location.href = path + "workflow/createworkflow.php";
                changeColour("CWF1");
                //window.frames['SideBar'].document.getElementById('S1').style.fontWeight ='100';
        }
        
        // function assignRepotingPerson(path) {                
        //         window.location.href = path + "workflow/assignRepotingPerson.php";
        //         changeColour("CWF1");
        //         //window.frames['SideBar'].document.getElementById('S1').style.fontWeight ='100';
        // }

		function transferWorkFlow(path) {                
                window.location.href = path + "workflow/transferworkflow.php";
                changeColour("TWF1");
                //window.frames['SideBar'].document.getElementById('S1').style.fontWeight ='100';
        }
        
        function viewWorkFlow(path) {                
                window.location.href = path + "workflow/wfstatus.php";
                changeColour("CWF2");
                //window.frames['SideBar'].document.getElementById('S1').style.fontWeight ='100';
        }
        
        function viewWF(path) {                
                window.location.href = path + "workflow/UpdateWorkFlow.php";
                changeColour("WF2");
                //window.frames['SideBar'].document.getElementById('S1').style.fontWeight ='100';
        }

        function createtask(path) {
            // window.location.href = path + "task.php"
            window.location.href = path + "projecttask.php"
            changeColour("F3");
        }
		
		 function PMSemailBccGroup(path) {
            window.location.href = path + "PMSEmailBccGroup.php"
            changeColour("E1");
        }
		
		 function WFemailBccGroup(path) {
            window.location.href = path + "workflow/WorkFlowEmailBccGroup.php"
            changeColour("E2");
        }

        function creategroups(path) {
            window.location.href = path + "crtusergroup.php"
            changeColour("S1");
        }
        
        function createEquipments(path) {
            window.location.href = path + "workflow/crtEquipment.php"
            changeColour("CWF6");
        }
        
        function viewEQFlow(path) {
            window.location.href = path + "workflow/ViewWorkFlow.php"
            changeColour("CWF5");
        }
        
        function createMainType(path) {
            window.location.href = path + "workflow/crtMaintainanceType.php"
            changeColour("CWF3");
        }
        
        
        function createScehdMt(path) {
            window.location.href = path + "workflow/mtschedule.php"
            changeColour("CWF4");
        }
        
        function createScehdEMP(path) {			
            window.location.href = path + "workflow/EMPschedule.php"
            changeColour("CWF8");
        }

        function createuser(path) {
            // window.location.href = path + "crtsystemuser.php"
            window.location.href = path + "browseusers.php"
            changeColour("S2");
        }

        function accesscontrol(path) {
            window.location.href = path + "crtAccess.php"
            changeColour("S3");
        }

        function updateTask(path) {
            window.location.href = path + "updateTask.php"
            changeColour("P1");
        }

        function ApproveTask(path) {
            window.location.href = path + "ApproveTask.php"
            changeColour("P2");
        }

        function createEMPLOYEE(path) {
            window.location.href = path + "Employee.php"
            changeColour("S5");
        }
		
		function createDESIGNATION(path) {
            window.location.href = path + "Designation.php"
            changeColour("S5");
        }

         function projectstatus(path) {
                window.location.href = path + "reports/projectstatus.php"
        }

        function NoAccess(path) {
                window.location.href = path + "NoAccess.php"
        }

        function MailProjetStatus(path) {
                window.location.href = path + "class/Mail_projectstatus.php"
        }

        function MailDepartmentStatus(path) {
                window.location.href = path + "class/Mail_projectstatusDepartment.php"
        }

        function MailEmployeeStatus(path) {
                window.location.href = path + "class/Mail_projectstatusEmployee.php"
        }

        function PrintProjectStatus(path) {
            window.location.href = path + "projectvsReport.php"
            changeColour("R5");
        }

        function createTeam(path) {
            window.location.href = path + "UserFacility.php"
            changeColour("S4");
        }
        
        function userview(path) {
            window.location.href = path + "PMUserView.php"
            changeColour("PMU");
        }

        function createProjectCategory(path) {
            window.location.href = path + "crtprojectgroups.php"
            changeColour("F1");
        }
        
        function UserView(path) {
            window.location.href = path + "TaskUserView.php"
            changeColour("F1");
        }
		
		function WFUserTypes(path) {
            window.location.href = path + "workflow/UserwfCats.php"
            changeColour("CWF9");
        }
		
		function NoAccess(path) {        	
			window.location.href = path + "NoAccess.php";
        }
        
        function changeColour(id){
                    //alert(id);
            document.getElementById('P1').style.color='';
            document.getElementById('P1').style.fontWeight='';
            document.getElementById('P2').style.color='';
            document.getElementById('P2').style.fontWeight='';

            document.getElementById('R5').style.color='';
            document.getElementById('R5').style.fontWeight='';

            document.getElementById('F1').style.color='';
            document.getElementById('F1').style.fontWeight='';
            document.getElementById('F2').style.color='';
            document.getElementById('F2').style.fontWeight='';
            document.getElementById('F3').style.color='';
            document.getElementById('F3').style.fontWeight='';

            document.getElementById('S1').style.color='';
            document.getElementById('S1').style.fontWeight='';
            document.getElementById('S2').style.color='';
            document.getElementById('S2').style.fontWeight='';
            document.getElementById('S3').style.color='';
            document.getElementById('S3').style.fontWeight='';
            document.getElementById('S4').style.color='';
            document.getElementById('S4').style.fontWeight='';
            document.getElementById('S5').style.color='';
            document.getElementById('S5').style.fontWeight='';/**/

            document.getElementById('CWF1').style.color='';
            document.getElementById('CWF1').style.fontWeight='';/**/
			
			document.getElementById('TWF1').style.color='';
            document.getElementById('TWF1').style.fontWeight='';/**/		

            document.getElementById('CWF2').style.color='';
            document.getElementById('CWF2').style.fontWeight='';/**/

            document.getElementById('CWF3').style.color='';
            document.getElementById('CWF3').style.fontWeight='';/**/

            document.getElementById('CWF4').style.color='';
            document.getElementById('CWF4').style.fontWeight='';/**/

            document.getElementById('CWF5').style.color='';
            document.getElementById('CWF5').style.fontWeight='';/**/

            document.getElementById('CWF6').style.color='';
            document.getElementById('CWF6').style.fontWeight='';/**/

            document.getElementById('WF2').style.color='';
            document.getElementById('WF2').style.fontWeight='';/**/

            document.getElementById('CWF8').style.color='';
            document.getElementById('CWF8').style.fontWeight='';/**/

            document.getElementById('PMU').style.color='';
            document.getElementById('PMU').style.fontWeight='';/**/
			
			document.getElementById('CWF9').style.color='';
            document.getElementById('CWF9').style.fontWeight='';/**/

			document.getElementById('E1').style.color='';
            document.getElementById('E1').style.fontWeight='';
			document.getElementById('E2').style.color='';
            document.getElementById('E2').style.fontWeight='';


            document.getElementById(id).style.color='red';
            document.getElementById(id).style.fontWeight='bold';

        }
    </script>
</head>
<body>
    <label class="mMenuItem" style="padding-left: 5px;" onClick="Exit('<?php echo $path; ?>')">Log Out</label></br></br>
    
    <label <?php if($Menue == "Home") echo "class='mMenuItemS'"; else  echo "class='mMenuItem'";?> style="padding-left: 5px;" onClick="Go2HOME('<?php echo $path; ?>')">Home</label></br></br>

    <!--<label class="mTitle">Task Update</label></br>
    <table width="100%" cellspacing="2px" cellpading="0">
        <tr>
            <td>
                <label class="mMenuItem">Update Task</label>
            </td>
        </tr>
        <tr>
            <td>
                <label class="mMenuItem">Approve Task</label></br>
            </td>
        </tr>
    </table>-->
    </br>
    <label class="mTitle">Work Flow Update</label></br>
    <table width="100%" cellspacing="2px" cellpading="0">
        <tr>
            <td>
            <?php
                	if ( getUSERACCESSPOINTS($str_dbconnect,$_SESSION["LogUserGroup"], "WF2") == 1 ) { ?>
                		<label <?php if($Menue == "UpdateWF") echo "class='mMenuItemS'"; else  echo "class='mMenuItem'";?> id="WF2"  onclick="viewWF('<?php echo $path; ?>')">Update Work Flow</label></br>
				<?php
                        }else{ ?>
						<label <?php if($Menue == "UpdateWF") echo "class='mMenuItemS'"; else  echo "class='mMenuItem'";?> onClick="NoAccess('<?php echo $path; ?>')">Update Work Flow</label></br>		
				<?php }
                ?>
                
            </td>
		</tr>
		<tr>
			<td>
            <?php
                	if ( getUSERACCESSPOINTS($str_dbconnect,$_SESSION["LogUserGroup"], "CWF5") == 1 ) { ?>
                		<label id="CWF5" <?php if($Menue == "WFHistory") echo "class='mMenuItemS'"; else  echo "class='mMenuItem'";?> onClick="viewEQFlow('<?php echo $path; ?>')">User Level WF</label></br>
				<?php
                        }else{ ?>
						<label <?php if($Menue == "WFHistory") echo "class='mMenuItemS'"; else  echo "class='mMenuItem'";?> onClick="NoAccess('<?php echo $path; ?>')">User Level WF</label></br>		
				<?php }
                ?>
                
            </td>
        </tr>
    </table>
    </br>
    <label class="mTitle">PMS</label></br>
    <table width="100%" cellspacing="2px" cellpading="0">
		<tr>
             <td>
                <?php
                	if ( getUSERACCESSPOINTS($str_dbconnect,$_SESSION["LogUserGroup"], "R8") == 1 ) {  ?>
                	<label <?php if($Menue == "Home") echo "class='mMenuItemS'"; else  echo "class='mMenuItem'";?> onClick="Go2HOME('<?php echo $path; ?>')">Update Project Status</label></br>
				<?php
                        }else{ ?>
					<label <?php if($Menue == "Home") echo "class='mMenuItemS'"; else  echo "class='mMenuItem'";?> onClick="NoAccess('<?php echo $path; ?>')">Update Project Status</label></br>		
				<?php }
                ?>

				
            </td>
        </tr>   
        <tr>
            <td>
				<?php
                	if ( getUSERACCESSPOINTS($str_dbconnect,$_SESSION["LogUserGroup"], "R5") == 1 ) { ?>
                		<label <?php if($Menue == "ProjectVsReport") echo "class='mMenuItemS'"; else  echo "class='mMenuItem'";?> onClick="PrintProjectStatus('<?php echo $path; ?>')">Project wise Status</label></br>
				<?php
                        }else{ ?>
						<label <?php if($Menue == "ProjectVsReport") echo "class='mMenuItemS'"; else  echo "class='mMenuItem'";?> onClick="NoAccess('<?php echo $path; ?>')">Project wise Status</label></br>		
				<?php }
                ?>
        </td>
        </tr>
        <!--<tr>
            <td>
                <label <?php if($Menue == "Customer") echo "class='mMenuItemS'"; else  echo "class='mMenuItem'";?>>Project Status / Print</label></br>
            </td>
        </tr>-->  
        <tr>
            <td>
				<?php
                	if ( getUSERACCESSPOINTS($str_dbconnect,$_SESSION["LogUserGroup"], "R7") == 1 ) { ?>
                	<label id="PUS" <?php if($Menue == "UserView") echo "class='mMenuItemS'"; else  echo "class='mMenuItem'";?> onClick="UserView('<?php echo $path; ?>')">PMS User Level View</label></br>
				<?php
                        }else{ ?>
					<label id="PUS" <?php if($Menue == "UserView") echo "class='mMenuItemS'"; else  echo "class='mMenuItem'";?> onClick="NoAccess('<?php echo $path; ?>')">PMS User Level View</label></br>
				<?php }
                ?>
            </td>
        </tr>          
    </table> 
    </br>
    <label class="mTitle">Admin Project Creation</label></br>
    <table width="100%" cellspacing="2px" cellpading="0">
        <tr>
            <td>
				<?php
                    if ( getUSERACCESSPOINTS($str_dbconnect,$_SESSION["LogUserGroup"], "F1") == 1 ) { ?>
            	<label <?php if($Menue == "ProjectGroups") echo "class='mMenuItemS'"; else  echo "class='mMenuItem'";?> onClick="createProjectCategory('<?php echo $path; ?>')" >Create Project Departments</label></br>
				<?php
                    }else{ ?>
					<label <?php if($Menue == "ProjectGroups") echo "class='mMenuItemS'"; else  echo "class='mMenuItem'";?> onClick="NoAccess('<?php echo $path; ?>')" >Create Project Departments</label></br>
				<?php }
                ?>
            </td>
        </tr>
        <tr> 
            <!-- change CrtProject to projectbrowse -->
            <td>
				<?php
                        if ( getUSERACCESSPOINTS($str_dbconnect,$_SESSION["LogUserGroup"], "F2") == 1 ) { ?>
                <label <?php if($Menue == "CrtProject") echo "class='mMenuItemS'"; else  echo "class='mMenuItem'";?> onClick="createproject('<?php echo $path; ?>')"> Create Projects</label></br>
				<?php
                        }else{ ?>
					<label <?php if($Menue == "CrtProject") echo "class='mMenuItemS'"; else  echo "class='mMenuItem'";?> onClick="NoAccess('<?php echo $path; ?>')"> Create Projects</label></br>
				<?php }
                        ?>	
            </td>
        </tr>
        <tr>
            <td>
			<?php
                        if ( getUSERACCESSPOINTS($str_dbconnect,$_SESSION["LogUserGroup"], "F3") == 1 ) { ?>
                <label <?php if($Menue == "TASK") echo "class='mMenuItemS'"; else  echo "class='mMenuItem'";?> onClick="createtask('<?php echo $path; ?>')">Create Task</label></br>
			<?php
                        }else{ ?>	
						<label <?php if($Menue == "TASK") echo "class='mMenuItemS'"; else  echo "class='mMenuItem'";?> onClick="NoAccess('<?php echo $path; ?>')">Create Task</label></br>
			<?php }
                        ?>			
            </td>
        </tr>
         <tr>
            <td>
			<?php
                        if ( getUSERACCESSPOINTS($str_dbconnect,$_SESSION["LogUserGroup"], "E1") == 1 ) { ?>
                <label <?php if($Menue == "PMSEmailBccGroup") echo "class='mMenuItemS'"; else  echo "class='mMenuItem'";?> onClick="PMSemailBccGroup('<?php echo $path; ?>')">PMS Email Alert Group</label></br>
			<?php
                        }else{ ?>	
						<label <?php if($Menue == "PMSEmailBccGroup") echo "class='mMenuItemS'"; else  echo "class='mMenuItem'";?> onClick="NoAccess('<?php echo $path; ?>')">PMS Email Alert Group</label></br>
			<?php }
                        ?>			
            </td>
        </tr>
    </table>
    </br>
    <label class="mTitle">Admin Work Flow Creation</label></br>
    <table width="100%" cellspacing="2px" cellpading="0">
		<tr>
            <td>
                <?php
                    if ( getUSERACCESSPOINTS($str_dbconnect,$_SESSION["LogUserGroup"], "F1") == 1 ) { ?>
            	<label id="CWF9" <?php if($Menue == "CreateWFTypes") echo "class='mMenuItemS'"; else  echo "class='mMenuItem'";?> onClick="WFUserTypes('<?php echo $path; ?>')">User wise WF Types</label></br>
				<?php
                    }else{ ?>
					<label <?php if($Menue == "CreateWFTypes") echo "class='mMenuItemS'"; else  echo "class='mMenuItem'";?> onClick="NoAccess('<?php echo $path; ?>')" >User wise WF Types</label></br>
				<?php }
                ?>
            </td>
        </tr>
        <tr>
            <td>
            <?php
                    if ( getUSERACCESSPOINTS($str_dbconnect,$_SESSION["LogUserGroup"], "F1") == 1 ) { ?>
            	<label id="CWF1" <?php if($Menue == "CreateWF") echo "class='mMenuItemS'"; else  echo "class='mMenuItem'";?> onClick="createworkflow('<?php echo $path; ?>')">Assign Work Flow</label></br>
				<?php
                    }else{ ?>
					<label <?php if($Menue == "CreateWF") echo "class='mMenuItemS'"; else  echo "class='mMenuItem'";?> onClick="NoAccess('<?php echo $path; ?>')" >Assign Work Flow</label></br>
				<?php }
                ?>
                
            </td>
        </tr>

        <tr>
            <td>
            <?php
                    if ( getUSERACCESSPOINTS($str_dbconnect,$_SESSION["LogUserGroup"], "F1") == 1 ) { ?>
            	<label id="TWF1" <?php if($Menue == "TransWF") echo "class='mMenuItemS'"; else  echo "class='mMenuItem'";?> onClick="transferWorkFlow('<?php echo $path; ?>')">Transfer Work Flow</label></br>
				<?php
                    }else{ ?>
					<label <?php if($Menue == "TransWF") echo "class='mMenuItemS'"; else  echo "class='mMenuItem'";?> onClick="NoAccess('<?php echo $path; ?>')" >Transfer Work Flow</label></br>
				<?php }
                ?>
                
            </td>
        </tr>
        <tr>
            <td>
            <?php
                    if ( getUSERACCESSPOINTS($str_dbconnect,$_SESSION["LogUserGroup"], "F1") == 1 ) { ?>
            	<label id="CWF6" <?php if($Menue == "CreateEquip") echo "class='mMenuItemS'"; else  echo "class='mMenuItem'";?> onClick="createEquipments('<?php echo $path; ?>')">Create Equipment Types</label></br>
				<?php
                    }else{ ?>
					<label <?php if($Menue == "CreateEquip") echo "class='mMenuItemS'"; else  echo "class='mMenuItem'";?> onClick="NoAccess('<?php echo $path; ?>')" >Create Equipment Types</label></br>
				<?php }
                ?>
                
            </td>
        </tr>
        <tr>
            <td>
            <?php
                    if ( getUSERACCESSPOINTS($str_dbconnect,$_SESSION["LogUserGroup"], "F1") == 1 ) { ?>
            	 <label id="CWF3" <?php if($Menue == "CreateMT") echo "class='mMenuItemS'"; else  echo "class='mMenuItem'";?> onClick="createMainType('<?php echo $path;?>')">Maintenance Types</label></br>
				<?php
                    }else{ ?>
					<label <?php if($Menue == "CreateMT") echo "class='mMenuItemS'"; else  echo "class='mMenuItem'";?> onClick="NoAccess('<?php echo $path; ?>')" >Maintenance Types</label></br>
				<?php }
                ?>
               
            </td>
        </tr>
        <tr>
            <td>
            <?php
                    if ( getUSERACCESSPOINTS($str_dbconnect,$_SESSION["LogUserGroup"], "F1") == 1 ) { ?>
            	 <label id="CWF4" <?php if($Menue == "MtSch") echo "class='mMenuItemS'"; else  echo "class='mMenuItem'";?> onClick="createScehdMt('<?php echo $path; ?>')">Schedule Maintenance</label></br>
				<?php
                    }else{ ?>
					<label <?php if($Menue == "MtSch") echo "class='mMenuItemS'"; else  echo "class='mMenuItem'";?> onClick="NoAccess('<?php echo $path; ?>')" >Schedule Maintenance</label></br>
				<?php }
                ?>
               
            </td>
        </tr>
        <tr>
            <td>
            <?php
                    if ( getUSERACCESSPOINTS($str_dbconnect,$_SESSION["LogUserGroup"], "F1") == 1 ) { ?>
            	<label id="CWF8" <?php if($Menue == "EmpShd") echo "class='mMenuItemS'"; else  echo "class='mMenuItem'";?> onClick="createScehdEMP('<?php echo $path; ?>')">Schedule Employee</label></br>
				<?php
                    }else{ ?>
					<label <?php if($Menue == "EmpShd") echo "class='mMenuItemS'"; else  echo "class='mMenuItem'";?> onClick="NoAccess('<?php echo $path; ?>')" >Schedule Employee</label></br>
				<?php }
                ?>
                
            </td>
        </tr>
        <tr>
            <td>
            <?php
                    if ( getUSERACCESSPOINTS($str_dbconnect,$_SESSION["LogUserGroup"], "F1") == 1 ) { ?>
            	 <label id="CWF2" <?php if($Menue == "ViewWFlow") echo "class='mMenuItemS'"; else  echo "class='mMenuItem'";?> onClick="viewWorkFlow('<?php echo $path; ?>')">View Work flow</label></br>
				<?php
                    }else{ ?>
					<label <?php if($Menue == "ViewWFlow") echo "class='mMenuItemS'"; else  echo "class='mMenuItem'";?> onClick="NoAccess('<?php echo $path; ?>')" >View Work flow</label></br>
				<?php }
                ?>
               
            </td>
        </tr>
        
        <tr>
            <td>
			<?php
                        if ( getUSERACCESSPOINTS($str_dbconnect,$_SESSION["LogUserGroup"], "E1") == 1 ) { ?>
                <label <?php if($Menue == "WorkFlowEmailBccGroup") echo "class='mMenuItemS'"; else  echo "class='mMenuItem'";?> onClick="WFemailBccGroup('<?php echo $path; ?>')">WF Email Alert Group</label></br>
			<?php
                        }else{ ?>	
						<label <?php if($Menue == "WorkFlowEmailBccGroup") echo "class='mMenuItemS'"; else  echo "class='mMenuItem'";?> onClick="NoAccess('<?php echo $path; ?>')">WF Email Alert Group</label></br>
			<?php }
                        ?>			
            </td>
        </tr>
        
        <!--<tr>
            <td>
                <label id="CWF5" <?php if($Menue == "WFHistory") echo "class='mMenuItemS'"; else  echo "class='mMenuItem'";?> onclick="viewEQFlow('<?php echo $path; ?>')">User Level WF</label></br>
            </td>
        </tr>-->
    </table>
    </br>
    <label class="mTitle">Security Center</label></br>
    <table width="100%" cellspacing="2px" cellpading="0">
        <tr>
            <td>
            <?php
                        if ( getUSERACCESSPOINTS($str_dbconnect,$_SESSION["LogUserGroup"], "E1") == 1 ) { ?>
                 <label id="S1" <?php if($Menue == "UserGroups") echo "class='mMenuItemS'"; else  echo "class='mMenuItem'";?> onClick="creategroups('<?php echo $path; ?>')">User Groups</label></br>
			<?php
                        }else{ ?>	
						<label <?php if($Menue == "UserGroups") echo "class='mMenuItemS'"; else  echo "class='mMenuItem'";?> onClick="NoAccess('<?php echo $path; ?>')" >User Groups</label></br>
			<?php }
                        ?>	
               
            </td>
        </tr>
        <tr>
            <td>
            <?php
                        if ( getUSERACCESSPOINTS($str_dbconnect,$_SESSION["LogUserGroup"], "E1") == 1 ) { ?>
                <label id="S2" <?php if($Menue == "SystemUsers") echo "class='mMenuItemS'"; else  echo "class='mMenuItem'";?> onClick="createuser('<?php echo $path; ?>')">System Users</label></br>
			<?php
                        }else{ ?>	
						<label <?php if($Menue == "SystemUsers") echo "class='mMenuItemS'"; else  echo "class='mMenuItem'";?> onClick="NoAccess('<?php echo $path; ?>')" >System Users</label></br>
			<?php }
                        ?>	
                
            </td>
        </tr>
        <tr>
            <td>
            <?php
                        if ( getUSERACCESSPOINTS($str_dbconnect,$_SESSION["LogUserGroup"], "E1") == 1 ) { ?>
                <label id="S3" <?php if($Menue == "AccessControl") echo "class='mMenuItemS'"; else  echo "class='mMenuItem'";?> onClick="accesscontrol('<?php echo $path; ?>')">Access Control</label></br>
			<?php
                        }else{ ?>	
						<label <?php if($Menue == "AccessControl") echo "class='mMenuItemS'"; else  echo "class='mMenuItem'";?> onClick="NoAccess('<?php echo $path; ?>')" >Access Control</label></br>
			<?php }
                        ?>
                
            </td>
        </tr>
        <tr>
            <td>
            <?php
                        if ( getUSERACCESSPOINTS($str_dbconnect,$_SESSION["LogUserGroup"], "E1") == 1 ) { ?>
                <label id="S4" <?php if($Menue == "Teams") echo "class='mMenuItemS'"; else  echo "class='mMenuItem'";?> onClick="createTeam('<?php echo $path; ?>')">Teams</label></br>
			<?php
                        }else{ ?>	
						<label <?php if($Menue == "Teams") echo "class='mMenuItemS'"; else  echo "class='mMenuItem'";?> onClick="NoAccess('<?php echo $path; ?>')" >Teams</label></br>
			<?php }
                        ?>	
                
            </td>
        </tr>
        <tr>
            <td>
            <?php
                        if ( getUSERACCESSPOINTS($str_dbconnect,$_SESSION["LogUserGroup"], "E1") == 1 ) { ?>
                <label id="S5" <?php if($Menue == "Employee") echo "class='mMenuItemS'"; else  echo "class='mMenuItem'";?> onClick="createEMPLOYEE('<?php echo $path; ?>')">Employee Details</label></br>
			<?php
                        }else{ ?>	
						<label <?php if($Menue == "Employee") echo "class='mMenuItemS'"; else  echo "class='mMenuItem'";?> onClick="NoAccess('<?php echo $path; ?>')" >Employee Details</label></br>
			<?php }
                        ?>	
                
            </td>
        </tr>
        <tr>
            <td>
            <?php
                        if ( getUSERACCESSPOINTS($str_dbconnect,$_SESSION["LogUserGroup"], "E1") == 1 ) { ?>
                <label id="S5" <?php if($Menue == "Designation") echo "class='mMenuItemS'"; else  echo "class='mMenuItem'";?> onClick="createDESIGNATION('<?php echo $path; ?>')">Designation Details</label></br>
			<?php
                        }else{ ?>	
						<label <?php if($Menue == "Designation") echo "class='mMenuItemS'"; else  echo "class='mMenuItem'";?> onClick="NoAccess('<?php echo $path; ?>')" >Designation Details</label></br>
			<?php }
                        ?>	
                
            </td>
        </tr>
    </table>
    </br>
</body>
</html>
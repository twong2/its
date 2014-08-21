        <div id="right">
            <!-- 
            *~*~*~* RIGHT COLUMN CONTENT *~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~
            -->
<style>
label{
width: 4em;
float: left;
text-align: right;
margin-right: 0.5em;
display: block
}</style>

            <table width="100%" border="0" cellpadding="2">
                <tr>
                    <td width="100%"><b>University of Hawai'i Information Technology Services Site License Customer Information
                        </b>
                    </td>
                </tr>
                <tr>
                    <td>University of Hawai'i Information Technology Services (ITS) has established this form to obtain basic required information on each department or person that acquires licenses and/or software through ITS Site Licensing program.
                        <br>
                        <br>
                        All site licenses will be assessed a charge on an annual basis for the period: July 1 through June 30 of the following year, during the first quarter of each fiscal year. Microsoft products are perpetual, one that fees that have no annual renewal fees (only Software Assurance licenses and subscriptions are renewable at the start of UH’s Microsoft contract). 
                        <br>
                        <br>
                        Exception to the above valid period will be made for Federal Fund Accounts Only. The billing period will be dependent on the authorized effective dates assigned to each account. Due to the federal law restrictions, federal fund accounts will be assessed their charges on a semiannual basis after services have been received.
                        <br>
                        <br>
                    </td>
                </tr>
                
                <form action="?section=confirmationForm" method="post" action="<?php $_SERVER['PHP_SELF'];?>">
                    <table>
                    <tr>
                        <td>
                            Please Check One:<input type="checkbox" name="identification" value="Faculty">Faculty
                                             <input type="checkbox" name="identification" value="Staff">Staff
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            Persons authorized to pickup software in addition to the contact above:
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            1.<input type="text" name="person1" size="50"  value="<?php if(isset($_POST['person1'])) echo $_POST['person1']?>">
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            2.<input type="text" name="person2" size="50"  value="<?php if(isset($_POST['person2'])) echo $_POST['person2']?>">
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            Please list the full description of the license as it is shown on the price list. If applicable, please specify if you would like to downgrade the license to a previous version. For CD-ROMs, please list the name and version of the CD you wish to purchase.
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            <textarea rows="10" cols="50" name="description" required vale="<?php if(isset($_POST['description'])) echo $_POST['description'];?>">
                        </textarea>
                        </td>
                    </tr>
                    
                    </table>
                    <input type="submit" name="submit" value="Submit">
                </form>
            </table>
        </div> <!-- left -->
    </div> <!-- wrapper-columns -->        
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Registration</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body>
    <div class="container text-center">
        <h1>Registration Form</h1>
        <p>Please fill out this form with the required information</p>
        <form class="p-3" method="post"> <!--action hinzufügen-->
            <div class="mb-3">


                <label class="form-label" for="firstname">Enter your first name:</label>
                <input class="form-control" type="text" id="firstname" name="fist-name" required>

                <label class="form-label" for="lastname"> Enter your last name: </label>
                <input class="form-control" type="text" id="lastname" name="lastname" required>

                <label class="form-label" for="gebdatum">Geburtsdatum</label>
                <input class="form-control" id="gebdatum" type="date" min="1920-01-01" max="2009-11-02" name="gebdatum"> <!-- kann man programieren damit es sich automatisch ändert-->
                <div class="form-text text-muted">
                    Du musst mindestens 16 Jahre alt sein.<!--soll nur dann kommen wenn es falsch getippt wurde.--> 
                </div>

                <label class="form-label" for="email">Enter your Email: </label>
                <input class="form-control" type="email" id="email" name="email" required>

                <label class="form-label" for="password">Create your new password</label>
                <input class="form-control" type="password" id="password" pattern="[a-z0-9]{12,}" name="password">
                <!-- wenn man passwort sehen möchte wird nur den type gewechselt-->


            </div>
            <legend>Geschlecht </legend>
            <div class="form-check form-check-inline">
                <input class="form-check-input" id="weiblich" name="geschlecht" type="checkbox">
                <label class="form-check-label" for="weiblich">Weiblich</label>
            </div>

            <div class="form-check form-check-inline">
                <label class="form-check-label" for="maenlich">Männlich</label>
                <input class="form-check-input" id="maenlich" name="geschlecht" type="checkbox">
            </div>

            <div class="form-check form-check-inline">
                <label class="form-check-label" for="divers">Divers</label>
                <input class="form-check-input" id="divers" name="geschlecht" type="checkbox">
            </div>

            <div>

                <label for="profilbild">Upload a profile pciture <input id="profilbild" type="file" name="profilbild"> </label><br>
            </div>


            <div>
                <label class="form-label" for="referrer"> how did you hear about us?
                    <select class="form-select" id="referrer" name="referrer">
                        <option selected>(select one)</option>
                        <option value="1">FH</option>
                        <option value="2">Instagram</option>
                        <option value="3">Ana Florea</option>
                        <option value="4">other one</option>
                    </select>
                </label><br>
            </div>



            <label class="form-check-label" for="terms-and-conditions"> <input id="terms-and-conditions" type="checkbox" name="terms-and-conditions" required>
                I accept the <a href="https://www.freecodecamp.org/news/terms-of-service/">terms and conditions</a> </label><br>

            <input type="submit" value="Register">

        </form>


    </div>
</body>
</html>
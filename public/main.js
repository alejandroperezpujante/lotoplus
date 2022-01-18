/*
Function that checks if the given input
is 45 caracters long or less. And that
only contains letters and spaces
*/

function checkName(input) {
	return !!(input.length <= 45 && input.match(/^[a-zA-Z ]+$/));

}

/*
Function that checks if the given input
is 65 caracters long or less. And that
only contains letters, spaces and hyphens
*/

function checkSurname(input) {
	return !!(input.length <= 65 && input.match(/^[a-zA-Z -]+$/));

}

/*
Function that checks if the given input
is 3 caracters minimin and 30 caracters max. And that
only contains letters or numbers
*/

function checkUsername(input) {
	return !!(input.length >= 3 &&
		input.length <= 30 &&
		input.match(/^[a-zA-Z0-9]+$/));

}

/*
Function that checks the strength of the given password
assigning a score to it.
*/

function checkPassword(input) {
	let score = 0;
	if (input.match(/[a-z]/g)) {
		score += 1;
	}
	if (input.match(/[A-Z]/g)) {
		score += 1;
	}
	if (input.match(/\d/g)) {
		score += 1;
	}
	if (input.match(/\W/g)) {
		score += 1;
	}
	score += Math.floor(input.length/5);
	return score;
}

/*
Function that checks if the given email
has the correct format
*/

function checkEmail(input) {
	return !!input.match(/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/);

}

/*
Function that checks if the given date
corresponds to a 18 years old or older
*/

function checkDate(input) {
	let today = new Date();
	let birthDate = new Date(input);
	return today.getFullYear() - birthDate.getFullYear() >= 18;

}

/*
Function that checks if the phone number
is valid in Spain
*/

function checkPhone(input) {
	return !!input.match(/^[6|7][0-9]{8}$/);

}

// Function that checks if the given profit is a number, it can be negative or positive

function checkProfit(input) {
	if (input.match(/^[-0-9]+$/)) {
		return true;
	}
}

// DOM manipulation

$(function () {

	// Inputs links
	const $name = $("#name");
	const $surname = $("#surname");
	const $username = $("#username");
	const $password = $("#password");
	const $email = $("#email");
	const $birth = $("#birth");
	const $profit = $("#profits");
	const $phone = $("#phone");
	const $submit = $("#submit");

	// Tips links
	const $nameTip = $("#name-tip");
	const $surnameTip = $("#surname-tip");
	const $usernameTip = $("#username-tip");
	const $passwordReveal = $("#password-reveal");
	const $passwordStrength = $("#password-strength");
	const $passwordTip = $("#password-tip");
	const $emailTip = $("#email-tip");
	const $birthTip = $("#birth-tip");
	const $profitTip = $("#profits-tip");
	const $phoneTip = $("#phone-tip");

	// Event listeners

	// Name validation
	$name.on("keyup", function () {
		if (checkName($(this).val())) {
			$(this).css("border-color", "green");
		} else {
			$(this).css("border-color", "red");
		}
	});

	// Name tip
	$name.on("mouseover", function () {
		$nameTip.removeClass("hidden");
	});

	$name.on("mouseout", function () {
		$nameTip.addClass("hidden");
	});

	// Surname validation
	$surname.on("keyup", function () {
		if (checkSurname($(this).val())) {
			$(this).css("border-color", "green");
		} else {
			$(this).css("border-color", "red");
		}
	});

	// Surname tip
	$surname.on("mouseover", function () {
		$surnameTip.removeClass("hidden");
	});

	$surname.on("mouseout", function () {
		$surnameTip.addClass("hidden");
	});

	// Username validation
	$username.on("keyup", function () {
		if (checkUsername($(this).val())) {
			$(this).css("border-color", "green");
		} else {
			$(this).css("border-color", "red");
		}
	});

	// Username tip
	$username.on("mouseover", function () {
		$usernameTip.removeClass("hidden");
	});

	$username.on("mouseout", function () {
		$usernameTip.addClass("hidden");
	});

	// Password validation
	$password.on("keyup", function () {
		let score = checkPassword($(this).val());
		switch (score) {
			case 0:
				$passwordStrength.text("Password is not strong enough");
				break;

			case 1:
				$passwordStrength.text("Password is weak");
				break;

			case 2:
				$passwordStrength.text("Password is medium");
				break;

			case 3:
				$passwordStrength.text("Password is strong");
				break;

			case 4:
				$passwordStrength.text("Password is very strong");
				break;

			case 5:
				$passwordStrength.text("Password is extremely strong");
				break;
		}
	});

	// Pasword reveal
	$passwordReveal.on("click", function () {
		if ($password.attr("type") === "password") {
			$password.attr("type", "text");
			$passwordReveal.attr("src", "../src/assets/open-eye.svg");
		} else {
			$password.attr("type", "password");
			$passwordReveal.attr("src", "../src/assets/closed-eye.svg");
		}
	});

	// Password tip
	$password.on("mouseover", function () {
		$passwordTip.removeClass("hidden");
	});

	$password.on("mouseout", function () {
		$passwordTip.addClass("hidden");
	});

	// Email validation
	$email.on("keyup", function () {
		if (checkEmail($(this).val())) {
			$(this).css("border-color", "green");
		} else {
			$(this).css("border-color", "red");
		}
	});

	// Email tip
	$email.on("mouseover", function () {
		$emailTip.removeClass("hidden");
	});

	$email.on("mouseout", function () {
		$emailTip.addClass("hidden");
	});

	// Birth validation
	$birth.on("change", function () {
		if (checkDate($(this).val())) {
			$(this).css("border-color", "green");
		} else {
			$(this).css("border-color", "red");
		}
	});

	// Birth tip
	$birth.on("mouseover", function () {
		$birthTip.removeClass("hidden");
	});

	$birth.on("mouseout", function () {
		$birthTip.addClass("hidden");
	});

	// Profit validation
	$profit.on("keyup", function () {
		if (checkProfit($(this).val())) {
			$(this).css("border-color", "green");
		} else {
			$(this).css("border-color", "red");
		}
	});

	// Profit tip
	$profit.on("mouseover", function () {
		$profitTip.removeClass("hidden");
	});

	$profit.on("mouseout", function () {
		$profitTip.addClass("hidden");
	});

	// Phone validation
	$phone.on("keyup", function () {
		if (checkPhone($(this).val())) {
			$(this).css("border-color", "green");
		} else {
			$(this).css("border-color", "red");
		}
	});

	// Phone tip
	$phone.on("mouseover", function () {
		$phoneTip.removeClass("hidden");
	});

	$phone.on("mouseout", function () {
		$phoneTip.addClass("hidden");
	});

	// Form validation
	$(document).on("keyup", function () {
		if (
			checkName($name.val()) &&
			checkSurname($surname.val()) &&
			checkUsername($username.val()) &&
			checkEmail($email.val()) &&
			checkDate($birth.val()) &&
			checkPhone($phone.val()) &&
			checkProfit($profit.val())
		) {
			$submit.removeAttr("disabled");
			$submit.css("background-color", "green");
		} else {
			$submit.attr("disabled", "disabled");
			$submit.addClass("bg-gray-500");
		}
	});
});

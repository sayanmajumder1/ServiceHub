let selectedType = null;

function selectAccount(type) {
  const userBtn = document.getElementById("userBtn");
  const providerBtn = document.getElementById("providerBtn");

  if (selectedType === type) {
    selectedType = null;
    resetButton(userBtn);
    resetButton(providerBtn);
    return;
  }

  selectedType = type;

  if (type === "user") {
    setActive(userBtn);
    resetButton(providerBtn);
  } else {
    setActive(providerBtn);
    resetButton(userBtn);
  }
}

function setActive(button) {
  button.style.backgroundColor = "#AD46FF";
  button.classList.remove("text-gray-500");
  button.classList.add("text-white");
}

function resetButton(button) {
  button.style.backgroundColor = "#ffffff";
  button.classList.remove("text-white");
  button.classList.add("text-gray-500");
}

function goToNextStep() {
  if (!selectedType) {
    alert("Please select an account type.");
    return;
  }

  document.getElementById("step1").classList.add("hidden");

  const img = document.querySelector(".img1 img");
  const caption = document.querySelector(".img1").nextElementSibling;

  if (selectedType === "provider") {
    document.getElementById("step3Provider").classList.remove("hidden");
    img.src = "./7400904.jpg";
    caption.textContent = "Let’s build your service profile!";
  } else if (selectedType === "user") {
    document.getElementById("step3User").classList.remove("hidden");
    img.src = "./4707071.jpg";
    caption.textContent = "Let’s create your personal profile!";
  }
}

function goBackToStep1() {
  document.getElementById("step3User").classList.add("hidden");
  document.getElementById("step3Provider").classList.add("hidden");
  document.getElementById("step1").classList.remove("hidden");

  const img = document.querySelector(".img1 img");
  const caption = document.querySelector(".img1").nextElementSibling;

  img.src = "./4219239.jpg";
  caption.textContent = "Get thousands of services at one click";
}

function goToStep4Otp() {
  document.getElementById("step3User").classList.add("hidden");
  document.getElementById("step3Provider").classList.add("hidden");
  document.getElementById("step4Otp").classList.remove("hidden");
}

function goBackToStep3() {
  document.getElementById("step4Otp").classList.add("hidden");

  if (selectedType === "provider") {
    document.getElementById("step3Provider").classList.remove("hidden");
  } else if (selectedType === "user") {
    document.getElementById("step3User").classList.remove("hidden");
  }
}

function submitOtp() {
  const otpInputs = document.querySelectorAll(".otp-input");
  const otpValue = Array.from(otpInputs).map(input => input.value).join('');

  if (otpValue.length === 6) {
    alert(`OTP Submitted: ${otpValue}`);
    // Proceed to next step or API call
  } else {
    alert('Please enter all 6 digits of the OTP.');
  }
}

// OTP Input Autofocus

document.addEventListener("DOMContentLoaded", () => {
  const inputs = document.querySelectorAll(".otp-input");

  inputs.forEach((input, index) => {
    input.addEventListener("input", () => {
      if (input.value.length === 1 && index < inputs.length - 1) {
        inputs[index + 1].focus();
      }
    });

    input.addEventListener("keydown", (e) => {
      if (e.key === "Backspace" && input.value === "" && index > 0) {
        inputs[index - 1].focus();
      }
    });
  });
});

function goToNextFromStep3() {
  const nameInput = document.querySelector("#step3User input[placeholder='Full Name']");
  const emailInput = document.querySelector("#step3User input[placeholder='Email']");
  const phoneInput = document.querySelector("#step3User input[type='tel']");
  const passInput = document.querySelector("#step3User input[placeholder='Password']");
  const confirmPassInput = document.querySelector("#step3User input[placeholder='Confirm Password']");

  if (!nameInput.value || !emailInput.value || !phoneInput.value || !passInput.value || !confirmPassInput.value) {
    alert("Please fill in all the fields.");
    return;
  }

  if (passInput.value !== confirmPassInput.value) {
    alert("Passwords do not match.");
    return;
  }

  goToStep4Otp();
}

function goToStep4() {
  goToStep4Otp();
}
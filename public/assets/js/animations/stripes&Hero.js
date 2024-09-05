gsap.to(".bar", 1.5, {
  delay: 0.5,
  height: 0,
  stagger: {
    amount: 0.5
  },
  ease: "power4.inOut",
});

gsap.from(".loginLogo", 1.5, {
  delay: 1,
  y: 700,
  stagger: {
    amount: 0.5,
  },
  ease: "power4.inOut",
});

gsap.from("#formLogin", 2, {
  delay: 1.5,
  y: 700,
  stagger: {
    amount: 0.5,
  },
  ease: "power4.inOut",
  onComplete: function() {
    document.querySelector(".overlay").style.display = "none";
  }
});
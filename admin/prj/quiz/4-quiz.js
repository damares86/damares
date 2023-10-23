
var quiz = {
  
  // (A) PROPERTIES
  // (A1) HTML ELEMENTS
  hQn : null, // question <div>
  hAns : null, // answer <div>

  // (A2) QUIZ FLAGS
  all : 0, // total number of questions
  now : 0, // current question
  ans : 0, // current correct answer
  score : 0, // current score

  // (B) INIT QUIZ
  init : () => {
    quiz.hQn = document.getElementById("quizQn");
    quiz.hAns = document.getElementById("quizAns");
    
    sessionStorage.clear();
    
    quiz.load();
  },

  // (C) LOAD NEXT QUESTION/ANSWER
  load : () => {

    // (C1) FORM DATA
    let data = new FormData();
    data.append("qn", quiz.now);

    // (C2) AJAX FETCH
    fetch("3-ajax.php", { method:"POST", body:data })
    .then(res => res.json()).then(qna => {
      // (C2-1) TOTAL NUMBER OF QUESTIONS

      if (quiz.now == 0) { quiz.all = qna.all; }

      
      
      // (C2-2) SET THE QUESTION
      quiz.hQn.innerHTML = qna.q;
      
      // (C2-3) SET THE OPTIONS
      quiz.ans = qna.a;
      quiz.hAns.innerHTML = "";
      qna.o.forEach((val, idx) => {
        let o = document.createElement("div");
        o.className = "option";
        o.id = "opt"+idx;
        o.innerHTML = val;
        o.onclick = () => quiz.pick(idx);
        quiz.hAns.appendChild(o);
      });
    });
  },

  // (D) PICK AN OPTION
  pick : idx => {

    // time inizio quiz
    // begin = Date.now();

    // (D1) DETACH ALL ONCLICK & SET RIGHT/WRONG CSS
    for (let o of quiz.hAns.getElementsByClassName("option")) {
      o.onclick = "";
    }
    let answer ;
    // (D2) CORRECT ANSWER?
    let o = document.getElementById("opt"+idx);
    if (idx == quiz.ans) {
      answer=1;
      quiz.score++;
      o.classList.add("correct");
    } else {
      answer=0;
      o.classList.add("wrong");
    }

    quiz.now++;
    // time fine quiz
    end = Date.now();
    let question = quiz.now ;
    var userArray = [answer,'prova',end];
    sessionStorage.setItem(question, JSON.stringify(userArray));

  
    // (D3) NEXT QUESTION OR END GAME
    setTimeout(() => {
      if (quiz.now < quiz.all) { quiz.load(); }
      else {
        quiz.hQn.innerHTML = `You have answered ${quiz.score} of ${quiz.all} correctly.`;
        quiz.hAns.innerHTML = "";

        var obj = Object.keys(sessionStorage).reduce(function(obj, key) {
          obj[key] = sessionStorage.getItem(key);
          return obj
       }, {});
       
        $.post("script.php", { total: obj });
        
      }
    }, 1000);
  },

  // (E) RESET QUIZ
  reset : () => {
    quiz.all = 0;
    quiz.now = 0;
    quiz.ans = 0;
    quiz.score = 0;
    quiz.draw();
  }
};
window.addEventListener("DOMContentLoaded", quiz.init);
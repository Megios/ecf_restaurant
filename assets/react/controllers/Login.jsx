import React, { useState } from "react";
import styled from "styled-components";

const Login = () => {
  const [emailLogin, setEmailLogin] = useState("");
  const [mdpLogin, setMdpLogin] = useState("");
  const [memory, setMemory] = useState(false);

  const handleEmailInput = (e) => setEmailLogin(e.target.value);
  const handleMdpInput = (e) => setMdpLogin(e.target.value);
  const handleMemory = (e) => setMemory(e.target.checked);

  const handleSubmit = (e) => {
    e.preventDefault();
    const connect = {
      Email: emailLogin,
      Mdp: mdpLogin,
      Memory: memory,
    };
    console.log(connect);
  };
  return (
    <Wrapper>
      <form method="post">
        <fieldset>
          <label htmlFor="email"> Email :</label>
          <input
            type="email"
            name="email"
            id="email"
            onChange={handleEmailInput}
          />
        </fieldset>
        <fieldset>
          <label htmlFor="mdp"> Email :</label>
          <input
            type="password"
            name="mdp"
            id="mdp"
            onChange={handleMdpInput}
          />
        </fieldset>
        <fieldset>
          <input
            type="checkbox"
            name="memory"
            id="memory"
            onChange={handleMemory}
          />
          <label htmlFor="memory">Se souvenir de moi</label>
        </fieldset>
        <button className="btn_main" onClick={(e) => handleSubmit(e)}>
          Envoyer !
        </button>
      </form>
    </Wrapper>
  );
};
const Wrapper = styled.div`
  display: flex;
  flex-direction: column;
  align-items: center;
  fieldset {
    width: 80%;
  }
  .btn_main {
    background: hsl(35, 57%, 36%, 0.5);
    border: 2px solid #392c1e;
    box-shadow: 0 1px 4px #392c1e;
    border-radius: 25px;
    align-self: end;
    margin-inline: 25%;
    margin-top: 20px;
  }

  .btn_main:hover {
    box-shadow: 0 0 4px #b6ac97;
    color: #392c1e;
  }

  .btn_main:active {
    box-shadow: inset 0 0 2px 1px #392c1e;
  }

  input[type="checkbox"] {
    -webkit-appearance: none;
    -moz-appearance: none;
    -ms-appearance: none;
  }
  input[type="checkbox"] {
    -border-radius: 4px;
    height: 15px;
    width: 15px;
    background: #b6ac97b3;
    border: 1px solid #b6ac97;
  }
  input[type="checkbox"]:checked {
    background: #b6ac97b3;
    &:before {
      content: "x";
      display: flex;
      color: black;
      font-size: 16px;
      position: relative;
      top: -8px;
      left: -3px;
    }
  }
`;
export default Login;

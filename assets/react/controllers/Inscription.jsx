import axios from "axios";
import React, { useState } from "react";
import styled from "styled-components";

const Inscription = (props) => {
  const [email, setEmail] = useState("");
  const [num, setNum] = useState("");
  const [nom, setNom] = useState("");
  const [mdp, setMdp] = useState("");
  const [mdpVerify, setMdpverify] = useState("");
  const [defaultAllergene, setDefaultAllergene] = useState("");
  const [defaultCouverts, setDefaultCouverts] = useState("");
  const [acceptCGU, setAcceptCGU] = useState(false);
  const [toast, setToast] = useState("");

  const handleSubmit = (e) => {
    e.preventDefault();
    let formulaire = {
      Email: email,
      Num: num,
      Nom: nom,
      Allergene: defaultAllergene,
      Couverts: defaultCouverts,
      MotDePasse: mdp,
      MotDePasseVerify: mdpVerify,
      acceptCGU: acceptCGU,
    };
    console.log(formulaire);
    axios
      .post("/addUser", formulaire)
      .then(function (response) {
        console.log(response.data.Message);
        setToast(true);
      })
      .catch(function (error) {
        console.log(error);
        setToast(false);
      });
  };

  const handleEmailInput = (e) => setEmail(e.target.value);
  const handleNumInput = (e) => setNum(e.target.value);
  const handleMdpInput = (e) => setMdp(e.target.value);
  const handleMdpVerifyInput = (e) => setMdpverify(e.target.value);
  const handleNomInput = (e) => setNom(e.target.value);
  const handleCouvertInput = (e) => setDefaultCouverts(e.target.value);
  const handleAllergeneInput = (e) => setDefaultAllergene(e.target.value);
  const handleAcceptCGU = (e) => setAcceptCGU(e.target.checked);
  return (
    <Wrapper>
      <h1>Créer son compte</h1>
      <form method="post" acceptCharset="UTF-8">
        <fieldset>
          <fieldset className="mailfield">
            <label htmlFor="email">Email :</label>

            <input
              id="email"
              type="email"
              name="email"
              onChange={handleEmailInput}
            />
          </fieldset>
          <fieldset>
            <label htmlFor="number">N° de téléphone :</label>

            <input id="tel" type="tel" name="tel" onChange={handleNumInput} />
          </fieldset>
        </fieldset>
        <fieldset>
          <label htmlFor="Mdp">Mot de passe :</label>

          <input
            id="Mdp"
            type="password"
            name="Mdp"
            onChange={handleMdpInput}
          />
        </fieldset>
        <fieldset>
          <label htmlFor="MdpVerify">Confirmer mot de passe :</label>

          <input
            id="MdpVerify"
            type="password"
            name="MdpVerify"
            onChange={handleMdpVerifyInput}
          />
        </fieldset>

        <fieldset>
          <label htmlFor="name">Nom de la reservation :</label>

          <input id="name" type="text" name="name" onChange={handleNomInput} />
        </fieldset>
        <fieldset>
          <label htmlFor="Couvert">Nombre de couverts par défault :</label>
          <input
            type="number"
            name="Couvert"
            id="Couvert"
            onChange={handleCouvertInput}
          />
        </fieldset>
        <fieldset>
          <label htmlFor="allergene">Allergène :</label>

          <textarea
            id="allergene"
            name="allergene"
            rows={5}
            cols={50}
            onChange={handleAllergeneInput}
          />
        </fieldset>
        <fieldset>
          <input
            type="checkbox"
            name="CGU"
            id="CGU"
            onChange={handleAcceptCGU}
          />
          <label htmlFor="CGU">
            J'accepte les <a href="/CGU">conditions générales d'utilisation</a>
          </label>
        </fieldset>

        <button className="btn_main" onClick={(e) => handleSubmit(e)}>
          Envoyer !
        </button>
      </form>
      {toast === true ? (
        <p>l'inscription c'est bien passez</p>
      ) : toast === "" ? null : (
        <p>une erreur est survenu</p>
      )}
    </Wrapper>
  );
};
const Wrapper = styled.div`
  form {
    display: flex;
    flex-direction: column;
    align-items: center;
  }
  label a {
    text-decoration: none;
    color: #b6ac97;
    cursor: pointer;
  }
  fieldset {
    width: 100%;
    display: flex;
    justify-content: center;
    border: none;
  }
  .mailfield input {
    width: 60%;
  }
  form input {
    background: #b6ac97b3;
    border: none;
    padding: 5px;
    width: 40%;
  }
  form label {
    width: 40%;
    text-align: end;
    margin: 0 5px;
  }
  label:last-child {
    text-align: start;
    width: auto;
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
  form textarea {
    background: #b6ac97b3;
    border: none;
    padding: 5px;
    align-self: end;
  }
  .btn_main {
    background: hsl(35, 57%, 36%, 0.5);
    border: 2px solid #392c1e;
    box-shadow: 0 1px 4px #392c1e;
    border-radius: 25px;
    align-self: end;
    margin-inline: 25%;
    margin-top: 20px;
    text-decoration: none;
    color: black;
    padding: 5px 10px;
  }

  .btn_main:hover {
    box-shadow: 0 0 4px #b6ac97;
    color: #392c1e;
  }

  .btn_main:active {
    box-shadow: inset 0 0 2px 1px #392c1e;
  }
`;
export default Inscription;

import axios from "axios";
import React, { useState } from "react";
import styled from "styled-components";

const AddSousCat = (props) => {
  const [nom, setNom] = useState("");
  const [nomCarte,setNomCarte] = useState("");
  const [ordre, setOrdre] = useState("");
  const [toast, setToast] = useState("");
  const [add, setAdd] = useState(false);

  const handleNomInput = (e) => {
    setNom(e.target.value);
    setToast("");
  };
  const handleCarteSelect = (e) => {
    setNomCarte(e.target.value);
    setToast("");
  }
  const handleOrdreInput = (e) => {
    setOrdre(e.target.value);
    setToast("");
  };
  const handleFerme = (e) => {
    setAdd(false);
  };
  const handleOuvre = (e) => {
    setAdd(true);
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    let formulaire = {
      Nom: nom,
      Carte: nomCarte,
      Ordre: ordre,
    };
    if(ordre <=0 || nom===""){
      setToast(false);
    }
    else{
      console.log(formulaire);
      axios
        .post("/addSousCat", formulaire)
        .then(function (response) {
          console.log(response.data.Message);
          setAdd(false);
          window.location.reload(false);
        })
        .catch(function (error) {
          console.log(error);
          setToast(false);
        });
    }
  };
  return (    
    <Wrapper>
      {add === true ? (
        <div id="actif">
          <button className="close" onClick={handleFerme}>
            X
          </button>
          <form method="post" acceptCharset="UTF-8">
            <label htmlFor="nom">Nom :</label>
            <input
              type="text"
              name="nom"
              id="nom"
              required
              onChange={handleNomInput}
            />
            <label htmlFor="carte">Carte :</label>
            <select name="carte" id="carte" onChange={handleCarteSelect} placeholder="Choisissez "> 
              <option value="" disabled selected>Select your option</option>
              {props.cartes.map((carte) => (
                <option value={carte['nom']}>{carte['nom']}</option>
              ))}
            </select>
            
            <label htmlFor="odre">Ordre :</label>
            <input
              type="number"
              name="ordre"
              id="ordre"
              required
              onChange={handleOrdreInput}
            />
            <button type="submit" onClick={handleSubmit}>
              Envoyer
            </button>
          </form>
          {toast === "" ? null : <p>une erreur est survenu</p>}
        </div>
      ) : <button className="btn_main " onClick={handleOuvre}>Ajouter une catégorie</button>}
    </Wrapper>
  );
};

const Wrapper = styled.div`
  #actif {
    display: flex;
    flex-direction: column;
    top: 20vh;
    margin: auto;
    background: white;
    border: 2px solid black;
    .close {
      align-self: end;
      margin:5px 10px;
    }
    form{
      display: flex;
    flex-direction: column;
    margin: 10px;
    }
  }
`;

export default AddSousCat;
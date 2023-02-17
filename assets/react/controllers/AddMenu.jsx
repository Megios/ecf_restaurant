import axios from "axios";
import React, { useState } from "react";
import styled from "styled-components";

const AddMenu = () => {
  const [titre, setTitre] = useState("");
  const [description, setDescription] = useState("");
  const [prix, setPrix] = useState("");
  const [ordre, setOrdre] = useState("");
  const [toast, setToast] = useState("");
  const [add, setAdd] = useState(false);

  const handleTitreInput = (e) => {
    setTitre(e.target.value);
    setToast("");
  };
  const handleDescriptionInput = (e) => {
    setDescription(e.target.value);
    setToast("");
  };
  const handlePrixInput = (e) => {
    setPrix(e.target.value);
    setToast("");
  };
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
      Titre: titre,
      Description: description,
      Prix: prix,
      Ordre: ordre,
    };
    if(ordre <=0 || titre==="" || description==="" || !Number.isInteger(parseInt(prix)) || prix<=0){
      setToast(false);
    }
    else{
      axios
        .post("/addMenu", formulaire)
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
            <label htmlFor="titre">Titre du menu :</label>
            <input
              type="text"
              name="titre"
              id="titre"
              required
              onChange={handleTitreInput}
            />
            <label htmlFor="description">Description :</label>
            <input
              type="text"
              name="description"
              id="description"
              required
              onChange={handleDescriptionInput}
            />
            <label htmlFor="Prix">Prix en centimes</label>
            <input
              type="number"
              name="Prix"
              id="Prix"
              required
              onChange={handlePrixInput}
            />
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
      ) : <button className="btn_main " onClick={handleOuvre}>Ajouter menu</button>}
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
export default AddMenu;

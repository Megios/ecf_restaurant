import axios from "axios";
import React, { useState } from "react";
import styled from "styled-components";

const AddProduit = (props) => {
  const [nom, setNom] = useState("");
  const [nomSousCat,setNomSousCat] = useState("");
  const [ordre, setOrdre] = useState("");
  const [prix,setPrix] = useState("");
  const [toast, setToast] = useState("");
  const [add, setAdd] = useState(false);

  const handleNomInput = (e) => {
    setNom(e.target.value);
    setToast("");
  };
  const handleSousCatSelect = (e) => {
    setNomSousCat(e.target.value);
    setToast("");
  }
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
      Nom: nom,
      SousCategorie: nomSousCat,
      Ordre: ordre,
      Prix: prix
    };
    if(ordre <=0 || nom===""){
      setToast(false);
    }
    else{
      console.log(formulaire);
      axios
        .post("/addProduit", formulaire)
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
            <label htmlFor="Prix">Prix en centimes</label>
            <input
              type="number"
              name="Prix"
              id="Prix"
              required
              onChange={handlePrixInput}
            />
            <label htmlFor="categorie">SousCatégorie :</label>
            <select name="categories" id="categories" onChange={handleSousCatSelect}>
              <option value="" disabled selected>Select your option</option>
              {props.parents.map((parent) => (
                <optgroup label={parent}>
                  {props.categories.map((categorie) =>(
                    (categorie['parent'] === parent)? <option value={categorie['nom']}>{categorie['nom']}</option>:null
                  ))}
                </optgroup>
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
      ) : <button className="btn_main " onClick={handleOuvre}>Ajouter un produit</button>}
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

export default AddProduit;
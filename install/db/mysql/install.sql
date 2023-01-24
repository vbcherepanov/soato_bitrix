create table if not exists vbch_soato
(
    ELEMENT_TYPE char(50),
    ADRESS_CODE char(50),
    DISTRICT_CODE char(50),
    CITY_CODE char(50),
    LOCALITY_CODE char(50),
    STREET_CODE char(50),
    SOATO char(50),
    CODE char(25),
    NAME char(255),
    REDUCTION char(15),
    ZIP char(50),
    ALT_NAME char(255),
    INDEX NAME(NAME),
    INDEX NAME_ELEMENT_TYPE(ELEMENT_TYPE,NAME),
    INDEX NAME_ELEMENT_TYPE_LOCALITY_CODE(LOCALITY_CODE,ELEMENT_TYPE,NAME)
);

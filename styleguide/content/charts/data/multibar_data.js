/*********************************************************************************
 * By installing or using this file, you are confirming on behalf of the entity
 * subscribed to the SugarCRM Inc. product ("Company") that Company is bound by
 * the SugarCRM Inc. Master Subscription Agreement (“MSA”), which is viewable at:
 * http://www.sugarcrm.com/master-subscription-agreement
 *
 * If Company is not bound by the MSA, then by installing or using this file
 * you are agreeing unconditionally that Company will be bound by the MSA and
 * certifying that you have authority to bind Company accordingly.
 *
 * Copyright (C) 2004-2013 SugarCRM Inc.  All rights reserved.
 ********************************************************************************/

var multibar_data_default = {
  "properties": {
    "title": "Forecasting for Q1 2012",
    "labels": [
      {"group": 1, "l": "Mark Gibson"},
      {"group": 2, "l": "Terence Li"},
      {"group": 3, "l": "James Joplin"},
      {"group": 4, "l": "Amy McCray"},
      {"group": 5, "l": "My Opps"}
    ],
    "values": [
      {"group": 1, "t": 110},
      {"group": 2, "t": 220},
      {"group": 3, "t": 260},
      {"group": 4, "t": 270},
      {"group": 5, "t": 270}
    ]
  },
  "data": [
    {
      "key": "Qualified",
      "type": "bar",
      "values": [
        {"series": 0, "x": 1, "y": 50,  "y0": 0},
        {"series": 0, "x": 2, "y": 80,  "y0": 0},
        {"series": 0, "x": 3, "y": 100, "y0": 0},
        {"series": 0, "x": 4, "y": 100, "y0": 0},
        {"series": 0, "x": 5, "y": 100, "y0": 0}
      ]
    },
    {
      "key": "Proposal",
      "type": "bar",
      "values": [
        {"series": 1, "x": 1, "y": 50,  "y0":  50},
        {"series": 1, "x": 2, "y": 80,  "y0":  80},
        {"series": 1, "x": 3, "y": 100, "y0": 100},
        {"series": 1, "x": 4, "y": 100, "y0": 100},
        {"series": 1, "x": 5, "y": 100, "y0": 100}
      ]
    },
    {
      "key": "Negotiation",
      "type": "bar",
      "values": [
        {"series": 2, "x": 1, "y": 10, "y0": 100},
        {"series": 2, "x": 2, "y": 50, "y0": 160},
        {"series": 2, "x": 3, "y": 40, "y0": 200},
        {"series": 2, "x": 4, "y": 40, "y0": 200},
        {"series": 2, "x": 5, "y": 40, "y0": 200}
      ]
    },
    {
      "key": "Closed",
      "type": "bar",
      "values": [
        {"series": 3, "x": 1, "y":  0, "y0": 110},
        {"series": 3, "x": 2, "y": 10, "y0": 210},
        {"series": 3, "x": 3, "y": 20, "y0": 240},
        {"series": 3, "x": 4, "y": 30, "y0": 240},
        {"series": 3, "x": 5, "y": 30, "y0": 240}
      ]
    }
  ]
};


var multibar_data_color = {
  "properties": {
    "title": "Forecasting for Q1 2012",
    "labels": [
      {"group": 1, "l": "Mark Gibson"},
      {"group": 2, "l": "Terence Li"},
      {"group": 3, "l": "James Joplin"},
      {"group": 4, "l": "Amy McCray"},
      {"group": 5, "l": "My Opps"}
    ],
    "values": [
      {"group": 1, "t": 110},
      {"group": 2, "t": 220},
      {"group": 3, "t": 260},
      {"group": 4, "t": 270},
      {"group": 5, "t": 270}
    ]
  },
  "data": [
    {
      "key": "Qualified",
      "type": "bar",
      "color": "#ffbb78",
      "classes": "nv-fill06",
      "values": [
        {"series": 0, "x": 1, "y": 50,  "y0": 0},
        {"series": 0, "x": 2, "y": 80,  "y0": 0},
        {"series": 0, "x": 3, "y": 100, "y0": 0},
        {"series": 0, "x": 4, "y": 100, "y0": 0},
        {"series": 0, "x": 5, "y": 100, "y0": 0}
      ]
    },
    {
      "key": "Proposal",
      "type": "bar",
      "color": "#ff7f0e",
      "classes": "nv-fill04",
      "values": [
        {"series": 1, "x": 1, "y": 50,  "y0":  50},
        {"series": 1, "x": 2, "y": 80,  "y0":  80},
        {"series": 1, "x": 3, "y": 100, "y0": 100},
        {"series": 1, "x": 4, "y": 100, "y0": 100},
        {"series": 1, "x": 5, "y": 100, "y0": 100}
      ]
    },
    {
      "key": "Negotiation",
      "type": "bar",
      "color": "#aec7e8",
      "classes": "nv-fill02",
      "values": [
        {"series": 2, "x": 1, "y": 10, "y0": 100},
        {"series": 2, "x": 2, "y": 50, "y0": 160},
        {"series": 2, "x": 3, "y": 40, "y0": 200},
        {"series": 2, "x": 4, "y": 40, "y0": 200},
        {"series": 2, "x": 5, "y": 40, "y0": 200}
      ]
    },
    {
      "key": "Closed",
      "type": "bar",
      "color": "#1f77b4",
      "classes": "nv-fill00",
      "values": [
        {"series": 3, "x": 1, "y":  0, "y0": 110},
        {"series": 3, "x": 2, "y": 10, "y0": 210},
        {"series": 3, "x": 3, "y": 20, "y0": 240},
        {"series": 3, "x": 4, "y": 30, "y0": 240},
        {"series": 3, "x": 5, "y": 30, "y0": 240}
      ]
    }
  ]
};
